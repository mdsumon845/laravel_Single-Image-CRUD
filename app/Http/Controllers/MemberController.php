<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use App\Models\Member;

class MemberController extends Controller
{
	public function index(){
    	return view('member.index');
  	}

  		//data store
  	public function store(Request $request){
    	$request->validate([
        //validation
        'name'=>'required',
        'email'=>'required|unique:members',
        'phone'=>'required',
        'image'=>'required',

    ],[
        //custom validation message
        'name.required'=>'必須項目',
        'email.required'=>'必須項目',
        'phone.required'=>'必須項目',
        'image.required'=>'必須項目',

    ]);
    
		if ($request->file('image')) {
			$Image = $request->file('image');
			$imgName = rand().$Image->getClientOriginalName();
			Image::make($Image)->resize(100, 80)->save('imgUpload/'.$imgName);
			$imgUrl = 'imgUpload/'.$imgName;
			$request->image = $imgUrl;
		}
			//data insert
		$member = new Member();
		$member->name = $request->name;
		$member->email = $request->email;
		$member->phone = $request->phone;
		$member->image= $imgUrl;
		$member->save();
		return redirect()->back()->with('message','データ正常に登録されました');
    }

        //show members data
	public function show(){
        $showMember = Member::OrderBy('id','desc')->paginate(4);
        // return $showMember;exit();
        return view('member.show',compact('showMember'));
    }

        //edit members data
    public function getMemberById($id){
        $member = Member::find($id);
        return view('member.edit',compact('member'));
    }

        //update members data
    public function updateMemberById(Request $request){
        $id = $request->id;
        $updateMember = Member::find($id);
        $oldImage = $updateMember->image;

            //image update
        if ($request->file('image')) {
            unlink($oldImage);
            $Image = $request->file('image');
            $imgName = rand().$Image->getClientOriginalName();
            Image::make($Image)->resize(100, 80)->save('imgUpload/'.$imgName);
            $imgUrl = 'imgUpload/'.$imgName;
            $updateMember->image = $imgUrl;
        }

        $updateMember->name = $request->name;
        $updateMember->email = $request->email;
        $updateMember->phone = $request->phone;
        $updateMember->save();
        return redirect()->route('member.list')->with('message','データ正常に更新されました');
    }

        // member data delete
    public function deleteMemberById($id){
        $memberDelete = Member::find($id);
        //image delete
        unlink($memberDelete->image);
        $memberDelete->delete();
        return redirect()->route('member.list')->with('message','データ正常に削除されました');
    }
}
