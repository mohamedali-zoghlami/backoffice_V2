<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Carbon\Carbon;
use App\Models\Role;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
     {if(auth()->user()->role!=="1")
        {$role1=Role::on("sqlsrv")->find(auth()->user()->role);
        if(!$role1)
            return redirect()->back()->with('error','Role introuvable !');
        if(!str_contains($role1->privilege,"u"))
            return redirect()->back()->with('error',"Vous n'avez pas le droit de modification !");

    }
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        $imagePath = time().'.'.$request->file('image')->getClientOriginalExtension();
        $request->file("image")->move(public_path('logo_images'), $imagePath);
        $image=Image::on("mysql")->first();
        if(!$image)
            $image=new Image();
        $image->image_path=$imagePath;
        $image->setConnection("mysql")->save();
        $image1=Image::on("sqlsrv")->first();
        $image1->timestamps=false;
        if(!$image1)
            {$image1=new Image();
                $image1->timestamps=false;
            $image1->created_at=Carbon::now()->format("Ymd H:i:s");
            }
        else
            $image1->updated_at=Carbon::now()->format("Ymd H:i:s");
        $image1->image_path=$imagePath;
        $image1->setConnection("sqlsrv")->save();
        $image1->timestamps=true;
        return redirect()->back()->with("success","Logo modifier avec succès");
    }

    public function getLogo()
    {
        $logo = Image::on("sqlsrv")->first(); // Assuming the logo you want is in row with ID 1
        if ($logo) {
            return $logo->image_path;
        }
        return asset('assets/images/logo-dark.png'); // Provide a default logo path if no record is found
    }
}
