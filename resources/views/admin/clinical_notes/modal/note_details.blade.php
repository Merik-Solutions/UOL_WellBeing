<style>
    .table td {
        border-top: none !important;
        width: auto !important;
    }
    .font_style {
        font-weight: 600 !important;
        font-size: 14px !important;
        color: #838383 !important;
        margin-right: 5px;
    }
    .font-14 {
        font-size: 14px !important;
    }
    hr {
        margin-top: 1rem;
        margin-bottom: 1rem;
        border: 0;
        border-top: 1px solid #dbdbdb;
        }
</style>
<div class="modal fade bd-example-modal-lg" id="note_detail_modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Clinical Note Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>            
                <div class="modal-body">
                    <div class="row p-2">
                        <div class="col-md-12 pt-2 px-3" style="border: 1px solid #dbdbdb;">
                            <div class="row" style="padding-top: 10px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Doctor:</label>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2" style="width:80px; height:80px;border-radius: 20px;overflow: hidden;">
                                                <img 
                                                src="{{$note->doctor->image ? url($note->doctor->image) : assets('dashboard/logo.png') }}" 
                                                alt="image" style="width: 100%;height: 100%;object-fit: cover;"/>
                                            </div>
                                            <div>
                                                <span> {{$note->doctor?->name ?? 'Kinda'}}  </span>
                                                <br>
                                                <span> {{$note->doctor?->email ?? 'No email'}}  </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Patient:</label>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2" style="width:80px; height:80px;border-radius: 20px;overflow: hidden;">
                                                <img 
                                                src="{{$note->patient->image ? url($note->patient->image) : assets('dashboard/logo.png') }}" 
                                                alt="image" style="width: 100%;height: 100%;object-fit: cover;"/>
                                            </div>
                                            <div>
                                                <span> {{$note->patient?->name ?? 'No name'}}  </span>
                                                <br>
                                                <span> {{$note->patient?->email ?? 'No email'}}  </span>
                                            </div>
                                             
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12"><hr></div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Allergy:</label>
                                        <p class="form-control border-0 rounded pr-0" style="height: auto;">
                                            {{ $note?->allergy ?? 'No allergy' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Medical History:</label>
                                        <p class="form-control border-0 rounded" style="height: auto;">
                                            {{ Str::ucfirst($note?->title ?? 'No title') }}
                                        </p>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Diagnosis:</label>
                                    <p class="form-control border-0 rounded" style="height: auto;">
                                        {{ $note?->diagnosis ?? 'No description given' }}
                                    </p>
    
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Medications:</label>
                                    <p class="form-control border-0 rounded" style="height: auto;">
                                        {{ $note?->description ?? 'No description given' }}
                                    </p>
                                </div>                           
                            </div>                      
                    
                        </div>

                       
                    </div>
                    <div class="p-2" style="font-size: 12px; display:flex; justify-content:space-between;">
                        <div>
                            <span style="margin-right: 5px;">Added on:</span>
                            <span>{{ date('d M Y g:i a', strtotime($note?->created_at)) }}</span>
                        </div>
                        <div>
                            <span style="margin-right: 5px;">Updated:</span>
                            <span>{{ date('d M Y g:i a', strtotime($note?->updated_at ?? '')) }}</span>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>
