<?php

namespace App\Livewire;

use App\Models\My_Parent;
use App\Models\Nationalitie;
use App\Models\ParentAttachment;
use App\Models\Religion;
use App\Models\Type_Bloods;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddParent extends Component
{
    use WithFileUploads;

    public $successMessage = '';
    public $currentStep = 1;
    public $add = false, $show = true , $update = false;
    public $Parent_id;
    // Father_INPUTS
    #[Validate] public $Email = '';
    #[Validate] public $Password = '';
    #[Validate] public $Name_Father = '';
    #[Validate] public $Name_Father_en = '';
    #[Validate] public $National_ID_Father = '';
    #[Validate] public $Passport_ID_Father = '';
    #[Validate] public $Phone_Father = '';
    #[Validate] public $Job_Father = '';
    #[Validate] public $Job_Father_en = '';
    #[Validate] public $Nationality_Father_id = '';
    #[Validate] public $Blood_Type_Father_id = '';
    #[Validate] public $Address_Father = '';
    #[Validate] public $Religion_Father_id = '';

    // Mother_INPUTS
    #[Validate] public $Name_Mother = '';
    #[Validate] public $Name_Mother_en = '';
    #[Validate] public $National_ID_Mother = '';
    #[Validate] public $Passport_ID_Mother = '';
    #[Validate] public $Phone_Mother = '';
    #[Validate] public $Job_Mother = '';
    #[Validate] public $Job_Mother_en = '';
    #[Validate] public $Nationality_Mother_id = '';
    #[Validate] public $Blood_Type_Mother_id = '';
    #[Validate] public $Address_Mother = '';
    #[Validate] public $Religion_Mother_id = '';
    //Attachment
    #[Validate] public $photos = []  , $OldPhoto = [];

    public function rules()
    {
        return [
            'Email' => 'required|email',
            'National_ID_Father' => 'required|string|size:10|regex:/^[0-9]{10}$/',
            'Passport_ID_Father' => 'nullable|size:10',
            'Phone_Father' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'National_ID_Mother' => 'required|string|size:10|regex:/^[0-9]{10}$/',
            'Passport_ID_Mother' => 'nullable|size:10',
            'Phone_Mother' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'photos.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',

        ];
    }


    public function ShowForm()
    {
        $this->show = false;
        $this->add = true;
         $this->currentStep = 1;

    }


    //firstStepSubmit
    public function firstStepSubmit()
    {
        $this->validate([
            'Email' => 'required|unique:my_parents,Email|email',
            'Password' => 'required|min:8',
            'Name_Father' => 'required',
            'Name_Father_en' => 'required',
            'Job_Father' => 'required',
            'Job_Father_en' => 'required',
            'National_ID_Father' => 'required|unique:my_parents,National_ID_Father|regex:/^[0-9]{10}$/',
            'Passport_ID_Father' => 'required|unique:my_parents,Passport_ID_Father',
            'Phone_Father' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Nationality_Father_id' => 'required',
            'Blood_Type_Father_id' => 'required',
            'Religion_Father_id' => 'required',
            'Address_Father' => 'required',
        ]);
        $this->currentStep = 2;
    }

    //secondStepSubmit
    public function secondStepSubmit()
    {

        $this->validate([
            'Name_Mother' => 'required',
            'Name_Mother_en' => 'required',
            'National_ID_Mother' => 'required|unique:my_parents,National_ID_Mother|regex:/^[0-9]{10}$/',
            'Passport_ID_Mother' => 'required|unique:my_parents,Passport_ID_Mother',
            'Phone_Mother' => 'required',
            'Job_Mother' => 'required',
            'Job_Mother_en' => 'required',
            'Nationality_Mother_id' => 'required',
            'Blood_Type_Mother_id' => 'required',
            'Religion_Mother_id' => 'required',
            'Address_Mother' => 'required',
        ]);

        $this->currentStep = 3;
    }


    //back
    public function back($step)
    {
        $this->currentStep = $step;
    }

    public function submitForm()
    {

        $this->validate(
            [
                'photos.*' => ['image', 'mimes:png,jpg,jpeg', 'max:2048']
            ],
            [
                'photos.*.image' => 'الملف يجب أن يكون صورة فقط.',
                'photos.*.mimes' => 'صيغة الصورة غير مدعومة. الصيغ المسموحة: jpg, jpeg, png, gif.',
                'photos.*.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميغابايت.',
            ]
        );

        $My_Parent = new My_Parent();
        // Father_INPUTS
        $My_Parent->Email = $this->Email;
        $My_Parent->Password = Hash::make($this->Password);
        $My_Parent->Name_Father = ['en' => $this->Name_Father_en, 'ar' => $this->Name_Father];
        $My_Parent->National_ID_Father = $this->National_ID_Father;
        $My_Parent->Passport_ID_Father = $this->Passport_ID_Father;
        $My_Parent->Phone_Father = $this->Phone_Father;
        $My_Parent->Job_Father = ['en' => $this->Job_Father_en, 'ar' => $this->Job_Father];
        $My_Parent->Nationality_Father_id = $this->Nationality_Father_id;
        $My_Parent->Blood_Type_Father_id = $this->Blood_Type_Father_id;
        $My_Parent->Religion_Father_id = $this->Religion_Father_id;
        $My_Parent->Address_Father = $this->Address_Father;

        // Mother_INPUTS
        $My_Parent->Name_Mother = ['en' => $this->Name_Mother_en, 'ar' => $this->Name_Mother];
        $My_Parent->National_ID_Mother = $this->National_ID_Mother;
        $My_Parent->Passport_ID_Mother = $this->Passport_ID_Mother;
        $My_Parent->Phone_Mother = $this->Phone_Mother;
        $My_Parent->Job_Mother = ['en' => $this->Job_Mother_en, 'ar' => $this->Job_Mother];
        $My_Parent->Passport_ID_Mother = $this->Passport_ID_Mother;
        $My_Parent->Nationality_Mother_id = $this->Nationality_Mother_id;
        $My_Parent->Blood_Type_Mother_id = $this->Blood_Type_Mother_id;
        $My_Parent->Religion_Mother_id = $this->Religion_Mother_id;
        $My_Parent->Address_Mother = $this->Address_Mother;
        $My_Parent->save();

        if (!empty($this->photos)) {
            foreach ($this->photos as $photo) {
                $photo->storeAs($this->National_ID_Father, $photo->getClientOriginalName(), $disk = 'parent_attachments');
                ParentAttachment::create([
                    'File_Name' => $photo->getClientOriginalName(),
                    'Parent_id' => My_Parent::latest()->first()->id,
                ]);
            }
        }



        $this->successMessage = trans('messages.success');
        $this->clearForm();
        $this->currentStep = 1;
    }

    public function clearForm()
    {
        $this->Email = '';
        $this->Password = '';
        $this->Name_Father = '';
        $this->Job_Father = '';
        $this->Job_Father_en = '';
        $this->Name_Father_en = '';
        $this->National_ID_Father = '';
        $this->Passport_ID_Father = '';
        $this->Phone_Father = '';
        $this->Nationality_Father_id = '';
        $this->Blood_Type_Father_id = '';
        $this->Address_Father = '';
        $this->Religion_Father_id = '';

        $this->Name_Mother = '';
        $this->Job_Mother = '';
        $this->Job_Mother_en = '';
        $this->Name_Mother_en = '';
        $this->National_ID_Mother = '';
        $this->Passport_ID_Mother = '';
        $this->Phone_Mother = '';
        $this->Nationality_Mother_id = '';
        $this->Blood_Type_Mother_id = '';
        $this->Address_Mother = '';
        $this->Religion_Mother_id = '';
    }

    public function edit($id)
    {
        
        $this->show = false;
        $this->add = false;
        $this->update = true;
        $My_Parent = My_Parent::where('id',$id)->first();
        $this->Parent_id = $id;
        $this->Email = $My_Parent->Email;
        // $this->Password = $My_Parent->Password;
        $this->Name_Father = $My_Parent->getTranslation('Name_Father', 'ar');
        $this->Name_Father_en = $My_Parent->getTranslation('Name_Father', 'en');
        $this->Job_Father = $My_Parent->getTranslation('Job_Father', 'ar');;
        $this->Job_Father_en = $My_Parent->getTranslation('Job_Father', 'en');
        $this->National_ID_Father =$My_Parent->National_ID_Father;
        $this->Passport_ID_Father = $My_Parent->Passport_ID_Father;
        $this->Phone_Father = $My_Parent->Phone_Father;
        $this->Nationality_Father_id = $My_Parent->Nationality_Father_id;
        $this->Blood_Type_Father_id = $My_Parent->Blood_Type_Father_id;
        $this->Address_Father =$My_Parent->Address_Father;
        $this->Religion_Father_id =$My_Parent->Religion_Father_id;

        $this->Name_Mother = $My_Parent->getTranslation('Name_Mother', 'ar');
        $this->Name_Mother_en = $My_Parent->getTranslation('Name_Father', 'en');
        $this->Job_Mother = $My_Parent->getTranslation('Job_Mother', 'ar');;
        $this->Job_Mother_en = $My_Parent->getTranslation('Job_Mother', 'en');
        $this->National_ID_Mother =$My_Parent->National_ID_Mother;
        $this->Passport_ID_Mother = $My_Parent->Passport_ID_Mother;
        $this->Phone_Mother = $My_Parent->Phone_Mother;
        $this->Nationality_Mother_id = $My_Parent->Nationality_Mother_id;
        $this->Blood_Type_Mother_id = $My_Parent->Blood_Type_Mother_id;
        $this->Address_Mother =$My_Parent->Address_Mother;
        $this->Religion_Mother_id =$My_Parent->Religion_Mother_id;
        $this->OldPhoto =ParentAttachment::where('Parent_id',$this->Parent_id)->pluck('File_Name')->toArray();
        
    }

    public function firstStepSubmit_edit()
    {
        $this->currentStep = 2;

    }

    // secondStepSubmit_edit
    public function secondStepSubmit_edit()
    {
        $this->currentStep = 3;

    }

    public function submitForm_edit(){
        $this->validate([
            'Email' => ['required', 'email', Rule::unique('my_parents', 'Email')->ignore($this->Parent_id)],
            'Password'=>['nullable','min:8'],
            'National_ID_Father'=>['required', Rule::unique('my_parents', 'National_ID_Father')->ignore($this->Parent_id)],
            'Passport_ID_Father'=>['required', Rule::unique('my_parents', 'Passport_ID_Father')->ignore($this->Parent_id)],
            'National_ID_Mother'=>['required', Rule::unique('my_parents', 'National_ID_Mother')->ignore($this->Parent_id)],
            'Passport_ID_Mother'=>['required', Rule::unique('my_parents', 'Passport_ID_Mother')->ignore($this->Parent_id)],
        ]);
        if ($this->Parent_id){
        $parent = My_Parent::findOrFail($this->Parent_id);
        $parent->Email = $this->Email;
        if ($this->Password != "") {
            $parent->Password = Hash::make($this->Password);
        }
        $parent->Name_Father = ['en' => $this->Name_Father_en, 'ar' => $this->Name_Father];
        $parent->National_ID_Father = $this->National_ID_Father;
        $parent->Passport_ID_Father = $this->Passport_ID_Father;
        $parent->Phone_Father = $this->Phone_Father;
        $parent->Job_Father = ['en' => $this->Job_Father_en, 'ar' => $this->Job_Father];
        $parent->Nationality_Father_id = $this->Nationality_Father_id;
        $parent->Blood_Type_Father_id = $this->Blood_Type_Father_id;
        $parent->Religion_Father_id = $this->Religion_Father_id;
        $parent->Address_Father = $this->Address_Father;

        // Mother_INPUTS
        $parent->Name_Mother = ['en' => $this->Name_Mother_en, 'ar' => $this->Name_Mother];
        $parent->National_ID_Mother = $this->National_ID_Mother;
        $parent->Passport_ID_Mother = $this->Passport_ID_Mother;
        $parent->Phone_Mother = $this->Phone_Mother;
        $parent->Job_Mother = ['en' => $this->Job_Mother_en, 'ar' => $this->Job_Mother];
        $parent->Nationality_Mother_id = $this->Nationality_Mother_id;
        $parent->Blood_Type_Mother_id = $this->Blood_Type_Mother_id;
        $parent->Religion_Mother_id = $this->Religion_Mother_id;
        $parent->Address_Mother = $this->Address_Mother;
        $this->OldPhoto = ParentAttachment::where('Parent_id',$this->Parent_id)->pluck('File_Name')->toArray();
        if (in_array($this->photos,$this->OldPhoto)) {
            $parent->save();
            
        }else{
            foreach ($this->photos as $photo) {
                $photo->storeAs($this->National_ID_Father, $photo->getClientOriginalName(), $disk = 'parent_attachments');
                ParentAttachment::create([
                    'File_Name' => $photo->getClientOriginalName(),
                    'Parent_id' => My_Parent::latest()->first()->id,
                ]);
            

        }
        $parent->save();
        }
        $this->successMessage = trans('messages.success');
        return redirect()->to('/add_parent');
    }
    }

    public function delete($id){
        
        $parent = My_Parent::findOrFail($id);
        Storage::disk('parent_attachments')->deleteDirectory($parent->National_ID_Father);
        ParentAttachment::where('Parent_id',$id)->delete();
        $parent->delete();
        return redirect()->to('/add_parent');
    }



    public function render()
    {
        
        return view('livewire.add-parent', [
            'Nationalities' => Nationalitie::all(),
            'Type_Bloods' => Type_Bloods::all(),
            'Religions' => Religion::all(),
            'my_parents' => My_Parent::all(),
        ]);
    }
}
