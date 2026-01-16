<tr data-item-key="{!! $iteration !!}" data-item-id="{!! $item->id??null !!}">
    <td>
        {!! Form::text("items[$iteration][medicine]",$item->medicine??"",['class'=>'form-control','parsley-trigger'=>'change','required']) !!}
        @error("items[$iteration][medicine]")
        <span class="invalid-feedback d-block" role="alert">
      <strong>{{ $message }}</strong>
    </span>
        @enderror
    </td>
    <td>
        {!! Form::text("items[$iteration][dose]",$item->dose??"",['class'=>'form-control','parsley-trigger'=>'change','required']) !!}

        @error("items[$iteration][dose]")
        <span class="invalid-feedback d-block" role="alert">
      <strong>{{ $message }}</strong>
    </span>
        @enderror

    </td>

    <td>
        {!! Form::textarea("items[$iteration][description]",$item->description??"",['class'=>'form-control','parsley-trigger'=>'change','required','rows'=>'1']) !!}

        @error("items[$iteration][description]")
        <span class="invalid-feedback d-block" role="alert">
      <strong>{{ $message }}</strong>
    </span>
        @enderror

    </td>
    <td>
        <a class=" btn btn-danger text-white" onclick="DeleteItem(this)"
           data-button.key="{!! $iteration !!}"> <i
                class="fas fa-times"></i></a>
    </td>
</tr>
