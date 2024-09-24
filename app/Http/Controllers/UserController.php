<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use File;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class UserController extends Controller
{
    public function index()
    {
        $iduser = Auth::user()->id_user;
        $userinfo = User::findOrFail($iduser);
        // dd($userinfo->name);
        return view('user.settinguser',compact('userinfo'));
    }
    public function manageuser()
    {
        // $iduser = Auth::user()->id_user;
        // $userinfo = User::findOrFail($iduser);
        // dd($userinfo->name);
        $datausers  = User::all();
        return view('user.tambahuser',compact('datausers'));
    }
    public function store(Request $request)
    {
        // $request->validate([
        //     'nopel' => 'required',
        //     'nop' => 'required',
        //     'id_jenis_pengajuan' => 'required',
        //     'berkas' => 'required|mimes:pdf|max:2048'
        // ]);
        if (User::where('username', $request->input('username'))->exists()) {
            return redirect()->route('manageuser')
            ->with('username', 'Username sudah ada!');       
        }
        
        $input = $request->all();
        $input['foto'] = 'user.png';
        User::create($input);
    
        // if ($berkas = $request->file('berkas')) {
        //     $destinationPath = 'public/berkas/';
        //     $namaberkas = $input['nopel'] ."_". $input['nop'] . "." . $berkas->getClientOriginalExtension();
        //     $berkas->move($destinationPath, $namaberkas);
        //     $input['berkas'] = "$namaberkas";
        // }
        return redirect()->route('manageuser')
            ->with('tambah', 'User '.$input['username'].' berhasil ditambahkan');
    }
    public function update(Request $request, $id): RedirectResponse
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'about' => 'required|min:20',
        //     'phone' => 'required',
        //     'email' => 'required',
        //     // Tambahkan aturan validasi lain sesuai kebutuhan
        // ]);
        $user = User::find($id);
        $input = $request->all();

        // dd($request->file('foto'));
        if ($foto = $request->file('foto')) {
            File::delete('public/user-profile/'.$user->foto);
            $destinationPath = 'public/user-profile/';
            $namaberkas = $user->id_user ."_". $input['name'] . "." . $foto->getClientOriginalExtension();
            $foto->move($destinationPath, $namaberkas);
            $input['foto'] = "$namaberkas";
        }else{
            unset($input['foto']);
        }
        // $user->update([
        //     'name' => $request->input('name'),
        //     'about' => $request->input('about'),
        // ]);
        // dd($foto);
        $user->update($input);
        return redirect()->route('user')
                         ->with('status', 'Data profile user sukses diupadate');
        // dd($input['phone']);
    
        // if ($berkas = $request->file('berkas')) {
        //     File::delete('berkas/'.$id->berkas);
        //     $destinationPath = 'berkas/';
        //     $namaberkas = $input['nopel'] ."_". $input['nop'] . "." . $berkas->getClientOriginalExtension();
            
        //     $berkas->move($destinationPath, $namaberkas);
        //     $input['berkas'] = "$namaberkas";
        // }else{
        //     unset($input['berkas']);
        // }
            
    }
    public function destroy($id)
    {
        $nama = User::find($id);
        if ($nama->foto <> 'user.png'){
        file::delete('public/user-profile/'.$nama->foto);
    }
    $nama->delete();
        return redirect()->route('manageuser')
        ->with('username', 'User '.$nama->username.' berhasil dihapus sukses');
    }

    public function showForm()
    {
        $datausers  = User::all();
        return view('user.tambahuser',compact('datausers'));
    }

    public function upload(Request $request)
    {
        // $request->validate([
        //     'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        // ]);
      
        // dd($request->file('images'));

        $images = $request->file('images');
        $imagePaths = [];
        $imagine = new Imagine();

        foreach ($images as $image) {
            $path = $image->store('image');
            $filePath = storage_path('app/' . $path);

              // Kompresi gambar
              $img = $imagine->open($filePath);
              $img->thumbnail(new Box(1000, PHP_INT_MAX))
                  ->save($filePath, ['quality' => 75]);

              $imagePaths[] = $filePath;
        }
        // dd($imagePaths);
       
         $this->convertImagesToPDF($imagePaths);
        
        return redirect()->back()->with('success', 'Images converted to PDF successfully.');
    }
    private function convertImagesToPDF($imagePaths)
    {
        $dompdf = new Dompdf();
        $dompdf->setOptions(new Options([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => false
        ]));
    
        $html = '<html><body>';
        foreach ($imagePaths as $imagePath) {
           
            if (file_exists($imagePath)) {
                $base64Image = base64_encode(file_get_contents($imagePath));
                $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
                $imgTag = '<img src="data:image/' . $imageExtension . ';base64,' . $base64Image . '" style="width:100%; height:auto; margin-bottom:20px;"/>';
                $html .= $imgTag;
            } else {
                $html .= '<p>Image not found: ' . htmlspecialchars($imagePath) . '</p>';
            }
        }
        $html .= '</body></html>';
    
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        $pdfPath = storage_path('app/pdf/merged.pdf');
    
        if (!file_exists(dirname($pdfPath))) {
            mkdir(dirname($pdfPath), 0755, true);
        }
    
        file_put_contents($pdfPath, $dompdf->output());
    
        return $pdfPath;
    }
    public function changePassword(Request $request)
    {
        // Validasi input
        $validator = FacadesValidator::make($request->all(), [
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('user')
                             ->with('status', 'Password gagal diubah!');
        }

        // Mengupdate password
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('user')
                         ->with('status', 'Password berhasil diubah!');
    }
}