<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\asset_images;
class Track extends Controller
{
    //view category
    public function category(){
        return view('addcategory');
    }
    //insert category
    public function insertcate(Request $req){
        $validateData=$req->validate([
            'name'=>'required|unique:categories',
            "desc"=>'required|min:5|max:500'
        ],['name.requried'=>'Name is required',
            'name.unique'=>"Name is unique",
            'desc.required'=>"Description is required",
        ]);
        if($validateData){
            Category::insert([
                'name'=>$req->name,
                'description'=>$req->desc,
            ]);
            return redirect('/category');
        }
    }
    //chart
    public function chart(){
        $grp=DB::select(DB::raw("select sum(quantity)as total, name from assets group by assets.category_id"));
        $dat="";
        foreach($grp as $i){
            $dat.=" ['".$i->name."'," .$i->total."],";
        }
        $data=$dat;
        return view('chart',compact('data'));
    }
    //bar chart
    public function bar(){
        $grp=DB::select(DB::raw("SELECT type, sum(case WHEN status=1 then quantity else 0 end)
         as active, sum(case WHEN status=0 then quantity else 0 end) as inactive from assets group by type order by active;"));
         return view('bar',['orders' => $grp]); 
    }
    //show category
    public function showcate(){
        $data=Category::paginate(3);
        return view('category',compact('data'));
    }
    //edit category
    public function editcate($id){
        $data=Category::find($id);
        return view('editcate',compact('data'));
    }
    //update category
    public function updatecate(Request $req){
        Category::where('id',$req->uid)->update([
            'name'=>$req->name,
            'description'=>$req->desc,
        ]);
        return redirect('/category');
    }
    //delete category
    public function delecate($id){
        Category::find($id)->delete();
        return redirect('/category');
    }
    public function product(){
        $data=Category::all();
        return view("addproduct",compact('data'));
    }
    public function showpro(){
        $data=Asset::paginate(2);
        return view('products',compact('data'));
    }
    public function insertpro(Request $req){
        $validateData=$req->validate([
            'name'=>'required',
            'category'=>'required',
            'quantity'=>'required',
            'status'=>'required',
            'image'=>'required|mimes:png,jpg,jpeg,jfif,PNG,JPEG,JPG'
        ],[
            'name.required'=>'Asset name is required',
            'category.required'=>'Select one',
            'quantity.required'=>'Enter the quantity',
            'status.required'=>'Select the status',
            'image.required'=>'Image is required',
            'image.mimes'=>'Incorrect format',
        ]);
        if($validateData){
        $filename=$req->name.rand().".".$req->image->extension();
        if($req->image->move(public_path('uploads/'),$filename)){
            $cat=Category::where('id',$req->category)->first();
            Asset::insert([
                'name'=>$req->name,
                'type'=>$cat->name,
                'category_id'=>$req->category,
                'quantity'=>$req->quantity,
                'status'=>$req->status,
                'image'=>$filename,
            ]);
            return redirect('/assets');
        }
        else{
            return back()->with("msg","not uploaded");
        }
    }
       
    }
    public function editpro($id){
        $data=Asset::find($id);
        $cat=Category::all();
        return view('editpro',compact('data','cat'));
    }
    public function updatepro(Request $req){
        $cat=Category::where('id',$req->category)->first();
        $validateData=$req->validate([
            'name'=>'required',
            'category'=>'required',
            'quantity'=>'required',
            'status'=>'required',
        ],[
            'name.required'=>'Asset name is required',
            'category.required'=>'Select one',
            'quantity.required'=>'Enter the quantity',
            'status.required'=>'Select the status',
        ]);
        if($validateData){
        Asset::where('id',$req->uid)->update([
            'name'=>$req->name,
                'type'=>$cat->name,
                'category_id'=>$req->category,
                'quantity'=>$req->quantity,
                'status'=>$req->status,
        ]);
        return redirect('/assets');
    }
    }
    public function delepro($id){
        Asset::find($id)->delete();
        return redirect('/assets');
    }
    public function imgLoad($id){
        $data=Asset::where('id',$id)->first();
       return view('imageuploading',compact('data'));
    }
    public function uploadd(Request $req){
        $filename=$req->name.rand().".".$req->image->extension();
        if($req->image->move(public_path('uploads/'),$filename)){
            asset_images::insert([
                'img_path'=>$filename,
                'asset_id'=>$req->uid,
            ]);
            return redirect('/assets');
        }
        else{
            return back()->with("msg","not uploaded");
        }
       
    }
    public function showimg($id){
        $pro=Asset::find($id);
        $imgs=$pro->Images;
        return view('showimg',compact('imgs','pro'));
    }
}
