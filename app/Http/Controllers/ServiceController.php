<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ServiceController extends Controller
{
    public function viewServiceAddForm(){
        return view('pages.admin-panel.service.add');
    }
    public function storeService(Request $req){
        $data = $req->validate([
            'title' => ['required', 'string', 'max:255'],
            'image_url' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $data['description'] = $data['short_description'];
        $data['price'] = $data['price'];
        unset($data['short_description']);

        Service::create($data);
        Alert::success('Success', 'Service create Successfull');

        return redirect()->route("viewServiceList");
    }

    public function viewServiceList(){
        $services = Service::get();

        return view("pages.admin-panel.service.list", ["data"=>$services]);
    }

    public function viewServiceEditForm($id){
        $service = Service::findOrFail($id);
        return view("pages.admin-panel.service.edit", ["service"=>$service]);
    }

    public function editService(Request $req){
        $validated = $req->validate([
            'id' => ['required', 'exists:services,id'],
            'title' => ['required', 'string', 'max:255'],
            'image_url' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'isActive' => ['nullable'],
        ]);

        $data['title'] = $validated['title'];
        $data['image_url'] = $validated['image_url'];
        $data['description'] = $validated['short_description'];
        $data['price'] = $validated['price'];
        $data['isActive'] = $req->isActive == "on" ? 1 : 0;

        Service::where(["id"=>$validated['id']])->update($data);
        Alert::success('Success', 'Service updated Successfully');

        return redirect()->route("viewServiceList");
    }

    public function deleteService(Service $service){
        if ($service->bookings()->exists()) {
            Alert::error('Error', 'This service cannot be deleted while it has bookings.');

            return redirect()->back();
        }

        $service->delete();

        Alert::success('Success', 'Service deleted Successfully');

        return redirect()->back();
    }
}
