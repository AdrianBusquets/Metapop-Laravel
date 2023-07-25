<?php

namespace App\Http\Livewire;

use App\Jobs\GoogleVisionRemoveFaces;
use App\Jobs\GoogleVisionLabelImage;
use App\Jobs\GoogleVisionSafeSearchImage;
use App\Jobs\ResizeImage;
use App\Models\Ad;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;




class CreateAd extends Component
{
    use WithFileUploads;
    public $title;
    public $body;
    public $price;
    public $category;
    public $images= [];
    public $temporary_images;
    public $image;

    protected $rules = [
        'title'=>'required|min:4',
        'body'=>'required|min:8',
        'category'=>'required',
        'price'=>'required|numeric'
    ];

    protected $messages = [
        'required'=>'Field :attribute is required, please fill it',
        'min'=>'Field :attribute should be longer than :min',
        'numeric'=>'Field :attribute must be a number',
        'temporary_images.required' => 'La imagen es obligatoria',
        'temporary_images.*.image' => 'Los archivos tienen que ser imagenes',
        'temporary_images.*.mas' => 'La imagen es demasiado grande',
        'images.image' => 'El archivo tiene que ser una imagen',
        'images.max' => 'La imagen es demasiado grande',
    ];

    public function store () {
        $validatedData = $this->validate();
        $category = Category::find($this->category);
        $ad = $category->ads()->create($validatedData);
        Auth::user()->ads()->save($ad);
        if (count($this->images)) {
            $newFileName = "ads/$ad->id";
            foreach($this->images as $image){
                $newImage = $ad->images()->create(['path'=>$image->store($newFileName, 'public')]);
                dispatch(new GoogleVisionRemoveFaces($newImage->id));
                dispatch(new ResizeImage($newImage->path, 400,400));
                dispatch(new ResizeImage($newImage->path, 400,300));
                dispatch( new GoogleVisionSafeSearchImage($newImage->id));
                dispatch( new GoogleVisionLabelImage($newImage->id));
            }
        File::deleteDirectory(storage_path('/app/livewire-tmp'));
        }
        session()->flash('message', __('Anuncio creado con éxito'));
        $this->cleanForm();
    }

    public function update($propertyName) {
        $this->validateOnly($propertyName);
    }
    public function updatedTemporaryImages(){
        if ($this->validate(['temporary_images.*'=>'image|max:2048'])){
            foreach($this-> temporary_images as $image){
                $this->images[] = $image;
            }
        }
    }
    public function removeImage($key){
        if(in_array($key, array_keys($this->images))){
            unset($this->images[$key]);
        }
    }

    public function cleanForm() {
        $this->title = "";
        $this->body = "";
        $this->category="";
        $this->price = "";
        $this->images = [];


    }


    public function render()
    {
        return view('livewire.create-ad');
    }
}
