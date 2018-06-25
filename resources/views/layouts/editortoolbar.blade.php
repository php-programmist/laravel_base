<button type="button" class="btn btn-success m-2" onclick="submit_button('apply')">
    {{__('system.save')}}
</button>

<button type="button" class="btn btn-success m-2" onclick="submit_button('save')">
    {{__('system.save_and_close')}}
</button>

<button type="button" class="btn btn-success m-2" onclick="submit_button('save2new')">
    {{__('system.save_and_new')}}
</button>

<a href="{{ route('admin.'.$view.'.index') }}">
    <button type="button" class="btn m-2 btn-danger">{{__('system.close')}}</button>
</a>