<div>
    {{-- رسالة النجاح --}}
    @if (!empty($successMessage))
        <div class="alert alert-success" id="success-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            {{ $successMessage }}
        </div>
    @endif

    {{-- جدول أولياء الأمور بعد الحفظ --}}
    @if ($show)
        @include('livewire.Parent_Table')
    @else
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step">
                    <a href="#step-1" type="button"
                        class="btn btn-circle {{ $currentStep != 1 ? 'btn-default' : 'btn-success' }}">1</a>
                    <p>{{ trans('Parent_trans.Step1') }}</p>
                </div>
                <div class="stepwizard-step">
                    <a href="#step-2" type="button"
                        class="btn btn-circle {{ $currentStep != 2 ? 'btn-default' : 'btn-success' }}">2</a>
                    <p>{{ trans('Parent_trans.Step2') }}</p>
                </div>
                <div class="stepwizard-step">
                    <a href="#step-3" type="button"
                        class="btn btn-circle {{ $currentStep != 3 ? 'btn-default' : 'btn-success' }}"
                        disabled>3</a>
                    <p>{{ trans('Parent_trans.Step3') }}</p>
                </div>
            </div>
        </div>

        
        <div wire:key="step-{{ $currentStep }}">
            @if ($currentStep == 1)
                @include('livewire.Father_Form')
            @endif

            @if ($currentStep == 2)
                @include('livewire.Mother_Form')
            @endif

            @if ($currentStep == 3)
                <div class="col-xs-12">
                    <div class="col-md-12">

                        <label style="color: red; font-size:30px;">{{ trans('Parent_trans.Attachments') }}</label>
                        <br><br>

                        <div class="form-group">
                            <input type="file" wire:model="photos" multiple>
                        </div>

                        <br>

                        @if ($photos)
                            <div class="row">
                                @foreach ($photos as $photo)
                                @if ($update)
                                <img src="{{  asset('storage/app/parent_attachments/' . $National_ID_Father . '/' . $photo) }}" width="100">
                                
                                @else
                                    <div class="col-md-3 mb-2">
                                        <img src="{{ $photo->temporaryUrl() }}" alt="Preview" width="100%"
                                            class="img-thumbnail">
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <br><br>

                        @error('photos.*')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        @foreach ($errors->get('photos.*') as $messages)
                            @foreach ($messages as $message)
                                <div class="alert alert-danger">{{ $message }}</div>
                            @endforeach
                        @endforeach

                        <br>

                        <div wire:loading wire:target="photos">جاري تحميل الصور...</div>

                        <h3 style="font-family: 'Cairo', sans-serif;">هل انت متأكد من حفظ البيانات؟</h3><br>

                        <button class="btn btn-danger btn-sm nextBtn btn-lg pull-right" type="button"
                            wire:click="back(2)">{{ trans('Parent_trans.Back') }}</button>

                            @if($update)
                            <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" wire:click="submitForm_edit"
                                    type="button">{{trans('Parent_trans.Finish')}}
                            </button>
                        @else
                            <button class="btn btn-success btn-sm btn-lg pull-right" wire:click="submitForm"
                                    type="button">{{ trans('Parent_trans.Finish') }}</button>
                        @endif

                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
