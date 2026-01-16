<style>
    .text-blue-dark{
        color: #004f9c;
        font-weight: 600;
    }
</style>
<div class="modal" id="package_modal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-xl" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Package Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="pb-3">
                    <h2>Package Info</h2>
                </div>
            
               
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><b>Doctor Name</b></td>
                            <td><span class="text-blue-dark">{{$package->doctor->name_en}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Patient Name</b></td>
                            <td><span class="text-blue-dark">{{$package->patient->name}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Price</b></td>
                            <td><span class="text-blue-dark">{{number_format($package->price,2)}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Bought On</b></td>
                            <td><span class="text-blue-dark">{{date('Y-m-d',strtotime($package->created_at))}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Expiry Date</b></td>
                            <td><span class="text-blue-dark">{{date('Y-m-d',strtotime($package->expired_at))}}</span></td>
                        </tr>

                        <tr>
                            <td><b>Status</b></td>
                            <td><span class="{{$package->expired_at < Carbon\Carbon::now() ? 'text-danger' : 'text-success'}}">{{$package->expired_at < Carbon\Carbon::now() ? 'Expired' : 'Active'}}</span></td>
                        </tr>
                     
                    </tbody>
                </table>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>