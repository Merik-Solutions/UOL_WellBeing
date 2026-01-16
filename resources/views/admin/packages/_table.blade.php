<style>
    .btn-green{
       background-color: #10c469;
   }
</style>
<table id="datatable-buttons" class="table table-striped table-bordered  ">
   <thead>
       <tr>
           <th>{!! __('Name') !!}</th>
           <th>{!! __('Description ') !!}</th>
           <th>{!! __('Min Price ') !!}</th>
           <th>{!! __('Max Price ') !!}</th>
           <th>{!! __('Expire In') !!}</th>
           {{-- <th>{!! __("Max Expire In ") !!}</th> --}}
           <th>{!! __('Quantity') !!}</th>
           <th>{!! __('Date') !!}</th>
           <th>{!! __('Actions') !!}</th>

       </tr>
   </thead>
   @foreach ($packages as $package)
       <tr>
           <td>{!! $package->name !!}</td>
           <td>{!! $package->description !!}</td>
           <td>{!! $package->min_price !!}</td>
           <td>{!! $package->max_price !!}</td>
           <td>{!! $package->expire_in !!}</td>
           {{-- <td>{!! $package->max_expire_in !!}</td> --}}
           <td>{!! $package->quantity !!}</td>
           @if ($package->created_at != NULL)
           <td>{!! $package->created_at !!}</td>
           @else
           <td>{!! __('No') !!} {!! __('Date') !!}</td>
           @endif
           <td>
               @component('admin.partials._edit_button', ['routeName' => 'packages', 'id' => $package->id, 'permission' => 'edit-packages'])
               @endcomponent 

               @component('admin.partials._delete_button', ['routeName' => 'packages', 'id' => $package->id, 'permission' => 'delete-packages'])
               @endcomponent 
               @if($package->isActive == 1)
                   <a href="{!! route('admin.package.status',$package->id) !!}" class="btn btn-warning my-1">
                       Deactivite
                   </a>
               @else
                   <a href="{!! route('admin.package.status',$package->id) !!}" class="btn btn-green my-1">
                       Activite
                   </a>
               @endif    
           </td>
       </tr>
   @endforeach
   <tbody>

   </tbody>
</table>
