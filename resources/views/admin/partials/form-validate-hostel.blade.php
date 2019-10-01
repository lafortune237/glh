@if($form == 'validate')

    <form hidden method="post" id="form_validate_hostel" action="{{route('admin.hostels.validate',['hostel'=>$hostel->id])}}">
        @csrf
    </form>
@endif

@if($form == 'unvalidate')
    <form hidden method="post" id="form_unvalidate_hostel" action="{{route('admin.hostels.unvalidate',['hostel'=>$hostel->id])}}">
        @csrf
    </form>
@endif
