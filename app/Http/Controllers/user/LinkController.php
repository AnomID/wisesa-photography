<?php

namespace App\Http\Controllers\user;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LinkController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'data_link' => 'required|array',
        ]);

        // Susunan json yang diinginkan dengan ID elemen yang benar
        $jsonFormat = [
            "order" => [
                "profil_pengguna",
                "grid_produk", 
                "tombol_link",
                "youtube_embeded",
                "sosial_media",
                "portfolio_project",
                "gambar_thumbnail",
                "spotify_embed"
            ],
            "timestamp" => now()->toIso8601String()
        ];

        // Gabungkan data_link dari request ke dalam format json yang diinginkan
        $dataLink = $request->data_link;
        $jsonFormat['data_link'] = $dataLink;

        $link = Link::create([
            'user_id' => auth()->user()->id,
            'data_link' => $jsonFormat,
        ]);

        return redirect()->route('editor')->with('success', 'Link berhasil disimpan dengan format json yang sesuai');
    }

    /**
     * Store atau update layout yang diatur oleh user dari editor
     */
    public function storeLayout(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'hidden' => 'nullable|array',
        ]);

        // Cek apakah user sudah memiliki data layout sebelumnya
        $existingLink = Link::where('user_id', auth()->user()->id)->first();

        if ($existingLink) {
            // Ambil data yang sudah ada
            $currentData = $existingLink->data_link ?? [];
            
            // Update hanya data layout (order dan hidden) tanpa menghapus data elemen yang sudah ada
            $currentData['order'] = $request->order;
            $currentData['hidden'] = $request->hidden ?? [];
            $currentData['timestamp'] = now()->toIso8601String();
            
            // Update data yang sudah ada
            $existingLink->update([
                'data_link' => $currentData
            ]);
            
            $message = 'Layout berhasil diupdate';
        } else {
            // Buat data baru dengan hanya layout data
            $layoutData = [
                "order" => $request->order,
                "hidden" => $request->hidden ?? [],
                "timestamp" => now()->toIso8601String()
            ];
            
            // Tambahkan background custom default jika belum ada
            if (!isset($layoutData['background_custom'])) {
                $layoutData['background_custom'] = [
                    'type' => 'image',
                    'image' => 'https://images.pexels.com/photos/1037992/pexels-photo-1037992.jpeg?cs=srgb&dl=pexels-moose-photos-170195-1037992.jpg&fm=jpg',
                    'updated_at' => now()->toIso8601String()
                ];
            }
            
            Link::create([
                'user_id' => auth()->user()->id,
                'data_link' => $layoutData,
            ]);
            
            $message = 'Layout berhasil disimpan';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $existingLink ? $existingLink->data_link : $layoutData
        ]);
    }

    /**
     * Update profil pengguna
     */
    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $existingLink = $this->getOrCreateUserLink();
            $currentData = $existingLink->data_link;
            
            // Handle upload foto profil
            $profileImagePath = $this->handleImageUpload($request, 'profile_image', 'profiles');
            
            // Update data profil_pengguna
            $currentData['profil_pengguna'] = [
                'username' => $request->username,
                'deskripsi' => $request->description,
                'foto_profil' => $profileImagePath ?: ($currentData['profil_pengguna']['foto_profil'] ?? 'https://pandekakode.com/env/saya.jpeg'),
                'updated_at' => now()->toIso8601String()
            ];

            $this->updateUserLink($existingLink, $currentData);

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diupdate!',
                'data' => $currentData['profil_pengguna']
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating profile', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update grid produk
     */
    public function updateGridProduk(Request $request)
    {
        try {
            $request->validate([
                'foto_produk.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'link_produk.*' => 'required|url',
                'harga.*' => 'required|string|max:100',
            ]);

            $existingLink = $this->getOrCreateUserLink();
            $currentData = $existingLink->data_link;
            
            $products = [];
            for ($i = 0; $i < count($request->foto_produk); $i++) {
                $imagePath = $this->handleImageUpload($request, "foto_produk.{$i}", 'products');
                $products[] = [
                    'foto_produk' => $imagePath,
                    'link_produk' => $request->link_produk[$i],
                    'harga' => $request->harga[$i],
                ];
            }

            $currentData['grid_produk'] = $products;
            $this->updateUserLink($existingLink, $currentData);

            return response()->json([
                'success' => true,
                'message' => 'Grid produk berhasil diupdate!',
                'data' => $currentData['grid_produk']
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating grid produk', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update tombol link
     */
    public function updateTombolLink(Request $request)
    {
        try {
            $request->validate([
                'nama_link.*' => 'required|string|max:255',
                'link_tombol.*' => 'required|url',
            ]);

            $existingLink = $this->getOrCreateUserLink();
            $currentData = $existingLink->data_link;
            
            $links = [];
            for ($i = 0; $i < count($request->nama_link); $i++) {
                $links[] = [
                    'nama_link' => $request->nama_link[$i],
                    'link_tombol' => $request->link_tombol[$i],
                ];
            }

            $currentData['tombol_link'] = $links;
            $this->updateUserLink($existingLink, $currentData);

            return response()->json([
                'success' => true,
                'message' => 'Tombol link berhasil diupdate!',
                'data' => $currentData['tombol_link']
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating tombol link', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update YouTube embedded
     */
    public function updateYoutubeEmbed(Request $request)
    {
        try {
            $request->validate([
                'header_youtube' => 'required|string|max:255',
                'deskripsi_header' => 'required|string|max:500',
                'embeded_youtube.*' => 'required|string',
            ]);

            $existingLink = $this->getOrCreateUserLink();
            $currentData = $existingLink->data_link;
            
            $currentData['youtube_embeded'] = [
                'header_youtube' => $request->header_youtube,
                'deskripsi_header' => $request->deskripsi_header,
                'embeded_youtube' => $request->embeded_youtube,
            ];

            $this->updateUserLink($existingLink, $currentData);

            return response()->json([
                'success' => true,
                'message' => 'YouTube embed berhasil diupdate!',
                'data' => $currentData['youtube_embeded']
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating YouTube embed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update sosial media
     */
    public function updateSosialMedia(Request $request)
    {
        try {
            // Debug: log the incoming request
            Log::info('Sosial media update request:', [
                'request_data' => $request->all(),
                'user_id' => auth()->user()->id
            ]);

            $request->validate([
                'sosial_media' => 'required|array',
                'sosial_media.*.platform' => 'required|string',
                'sosial_media.*.link' => 'required|url',
                'sosial_media.*.active' => 'boolean',
            ]);

            $existingLink = $this->getOrCreateUserLink();
            $currentData = $existingLink->data_link;
            
            // Ensure sosial_media key exists
            if (!isset($currentData['sosial_media'])) {
                $currentData['sosial_media'] = [];
            }
            
            $currentData['sosial_media'] = $request->sosial_media;
            $this->updateUserLink($existingLink, $currentData);

            Log::info('Sosial media updated successfully:', [
                'user_id' => auth()->user()->id,
                'data' => $currentData['sosial_media']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sosial media berhasil diupdate!',
                'data' => $currentData['sosial_media']
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating sosial media', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->user()->id
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update portfolio project
     */
    public function updatePortfolioProject(Request $request)
    {
        try {
            $request->validate([
                'gambar_project.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'judul_project.*' => 'required|string|max:255',
                'deskripsi_project.*' => 'required|string|max:500',
                'link_project.*' => 'required|url',
            ]);

            $existingLink = $this->getOrCreateUserLink();
            $currentData = $existingLink->data_link;
            
            $projects = [];
            for ($i = 0; $i < count($request->gambar_project); $i++) {
                $imagePath = $this->handleImageUpload($request, "gambar_project.{$i}", 'portfolio');
                $projects[] = [
                    'gambar_project' => $imagePath,
                    'judul_project' => $request->judul_project[$i],
                    'deskripsi_project' => $request->deskripsi_project[$i],
                    'link_project' => $request->link_project[$i],
                ];
            }

            $currentData['portfolio_project'] = $projects;
            $this->updateUserLink($existingLink, $currentData);

            return response()->json([
                'success' => true,
                'message' => 'Portfolio project berhasil diupdate!',
                'data' => $currentData['portfolio_project']
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating portfolio project', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update gambar thumbnail
     */
    public function updateGambarThumbnail(Request $request)
    {
        try {
            $request->validate([
                'gambar_thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $existingLink = $this->getOrCreateUserLink();
            $currentData = $existingLink->data_link;
            
            $imagePath = $this->handleImageUpload($request, 'gambar_thumbnail', 'thumbnails');
            
            $currentData['gambar_thumbnail'] = [
                'gambar_thumbnail' => $imagePath,
            ];

            $this->updateUserLink($existingLink, $currentData);

            return response()->json([
                'success' => true,
                'message' => 'Gambar thumbnail berhasil diupdate!',
                'data' => $currentData['gambar_thumbnail']
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating gambar thumbnail', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update Spotify embed
     */
    public function updateSpotifyEmbed(Request $request)
    {
        try {
            $request->validate([
                'embeded_spotify.*' => 'required|string',
            ]);

            $existingLink = $this->getOrCreateUserLink();
            $currentData = $existingLink->data_link;
            
            $currentData['spotify_embed'] = [
                'embeded_spotify' => $request->embeded_spotify,
            ];

            $this->updateUserLink($existingLink, $currentData);

            return response()->json([
                'success' => true,
                'message' => 'Spotify embed berhasil diupdate!',
                'data' => $currentData['spotify_embed']
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating Spotify embed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update background custom
     */
    public function updateBackgroundCustom(Request $request)
    {
        try {
            // Debug: log the incoming request
            Log::info('Background custom update request:', [
                'request_data' => $request->all(),
                'user_id' => auth()->user()->id,
                'files' => $request->allFiles()
            ]);

            $request->validate([
                'background_type' => 'required|in:image,color,gradient',
                'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'background_color' => 'nullable|string|max:7',
                'background_color_secondary' => 'nullable|string|max:7',
                'gradient_color_1' => 'nullable|string|max:7',
                'gradient_color_2' => 'nullable|string|max:7',
                'gradient_direction' => 'nullable|string|max:20',
            ]);

            $existingLink = $this->getOrCreateUserLink();
            $currentData = $existingLink->data_link;
            
            Log::info('Current data_link:', ['current_data' => $currentData]);
            
            $backgroundData = [
                'type' => $request->background_type,
                'updated_at' => now()->toIso8601String()
            ];

            if ($request->background_type === 'image') {
                $imagePath = $this->handleImageUpload($request, 'background_image', 'backgrounds');
                $backgroundData['image'] = $imagePath ?: 'https://images.pexels.com/photos/1037992/pexels-photo-1037992.jpeg?cs=srgb&dl=pexels-moose-photos-170195-1037992.jpg&fm=jpg';
                Log::info('Image upload result:', ['image_path' => $imagePath, 'final_image' => $backgroundData['image']]);
            } elseif ($request->background_type === 'color') {
                $backgroundData['color'] = $request->background_color;
                $backgroundData['color_secondary'] = $request->background_color_secondary;
                Log::info('Color data:', ['color' => $backgroundData['color'], 'color_secondary' => $backgroundData['color_secondary']]);
            } elseif ($request->background_type === 'gradient') {
                $backgroundData['gradient'] = [
                    'color1' => $request->gradient_color_1,
                    'color2' => $request->gradient_color_2,
                    'direction' => $request->gradient_direction
                ];
                Log::info('Gradient data:', ['gradient' => $backgroundData['gradient']]);
            }

            $currentData['background_custom'] = $backgroundData;
            Log::info('Updated background data:', ['background_custom' => $currentData['background_custom']]);
            
            $this->updateUserLink($existingLink, $currentData);

            Log::info('Background custom updated successfully:', [
                'user_id' => auth()->user()->id,
                'data' => $currentData['background_custom']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Background custom berhasil diupdate!',
                'data' => $currentData['background_custom']
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating background custom', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->user()->id
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method untuk mendapatkan atau membuat user link
     */
    private function getOrCreateUserLink()
    {
        $existingLink = Link::where('user_id', auth()->user()->id)->first();
        
        if (!$existingLink) {
            $existingLink = Link::create([
                'user_id' => auth()->user()->id,
                'data_link' => [
                    "order" => [
                        "profil_pengguna",
                        "grid_produk", 
                        "tombol_link",
                        "youtube_embeded",
                        "sosial_media",
                        "portfolio_project",
                        "gambar_thumbnail",
                        "spotify_embed",
                        "background_custom"
                    ],
                    "timestamp" => now()->toIso8601String()
                ]
            ]);
        }
        
        return $existingLink;
    }

    /**
     * Helper method untuk handle image upload
     */
    private function handleImageUpload(Request $request, $field, $folder)
    {
        if ($request->hasFile($field)) {
            $image = $request->file($field);
            $imageName = $folder . '_' . auth()->user()->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            
            $uploadPath = public_path($folder);
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $image->move($uploadPath, $imageName);
            return $folder . '/' . $imageName;
        }
        
        return null;
    }

    /**
     * Helper method untuk update user link
     */
    private function updateUserLink($link, $data)
    {
        $data['timestamp'] = now()->toIso8601String();
        $link->update(['data_link' => $data]);
    }

    /**
     * Test method untuk debugging
     */
    public function testProfile()
    {
        return response()->json([
            'success' => true,
            'message' => 'Test endpoint berfungsi',
            'user_id' => auth()->user()->id,
            'timestamp' => now()->toIso8601String()
        ]);
    }

    /**
     * Ambil layout yang tersimpan untuk user tertentu
     */
    public function getLayout()
    {
        $link = Link::where('user_id', auth()->user()->id)->first();
        
        if ($link) {
            return response()->json([
                'success' => true,
                'data' => $link->data_link
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Tidak ada layout tersimpan'
        ]);
    }
}
