<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;

class DashboardSuperAdminController extends Controller
{
   public function index()
   {
      return view('page_admin.dashboard.index');
   }

   /**
    * Get bookings by date
    */
   public function getBookingsByDate(Request $request)
   {
      $date = $request->input('date');

      $bookings = Booking::with(['layanan', 'subLayanan', 'user'])
         ->whereDate('booking_date', $date)
         ->latest()
         ->get();

      return response()->json([
         'success' => true,
         'bookings' => $bookings
      ]);
   }

   /**
    * Get calendar data for a month
    */
   public function getCalendarData(Request $request)
   {
      $year = $request->input('year', date('Y'));
      $month = $request->input('month', date('m'));

      // Get all bookings for the month
      $bookings = Booking::whereYear('booking_date', $year)
         ->whereMonth('booking_date', $month)
         ->get()
         ->groupBy(function ($booking) {
            return $booking->booking_date->format('Y-m-d');
         });

      $calendarData = [];

      // Generate days in month
      $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
      $firstDay = date('Y-m-01', strtotime("$year-$month-01"));

      for ($day = 1; $day <= $daysInMonth; $day++) {
         $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
         $fullDate = date('Y-m-d', strtotime("$year-$month-$day"));

         // Determine status for the day
         $dayStatus = null;
         if (isset($bookings[$fullDate])) {
            // Get the most important status (prioritize certain statuses)
            $statuses = $bookings[$fullDate]->pluck('status')->unique();

            // Priority order: Ditolak > Dibatalkan > Diproses > Diterima > Pending > Selesai
            if ($statuses->contains('Ditolak')) {
               $dayStatus = 'Ditolak';
            } elseif ($statuses->contains('Dibatalkan')) {
               $dayStatus = 'Dibatalkan';
            } elseif ($statuses->contains('Diproses')) {
               $dayStatus = 'Diproses';
            } elseif ($statuses->contains('Diterima')) {
               $dayStatus = 'Diterima';
            } elseif ($statuses->contains('Pending')) {
               $dayStatus = 'Pending';
            } elseif ($statuses->contains('Selesai')) {
               $dayStatus = 'Selesai';
            } else {
               $dayStatus = $statuses->first();
            }
         }

         $calendarData[] = [
            'date' => $day,
            'full_date' => $fullDate,
            'is_current_month' => true,
            'is_today' => $fullDate === date('Y-m-d'),
            'has_bookings' => isset($bookings[$fullDate]),
            'bookings_count' => isset($bookings[$fullDate]) ? $bookings[$fullDate]->count() : 0,
            'status' => $dayStatus,
         ];
      }

      return response()->json([
         'success' => true,
         'calendar_data' => $calendarData
      ]);
   }
}
