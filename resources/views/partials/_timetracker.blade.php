@csrf
<div class="form-group">
    <label for="formUsers"><b>User</b></label>
    
        @if(Auth::user()->is_admin)
            <select name="user_id" class="form-control" id="formUsers" placeholder="Username">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }}
                     </option>
                @endforeach
            </select>

        @else
            <select name="user_id" class="form-control" id="formUsers" placeholder="Username">
                <option>{{ $user->name }}</option>
            </select>
        @endif
</div>

<div id="app" class="form-group">
    <date-component name="start_day"></date-component>
</div>

<div class="form-group">
    <label for="categoryForm"><b>Category</b></label>
    <select class="form-control" name="category_id" id="categoryForm" placeholder="Category">
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">
                {{ $category->type }}
            </option>
        @endforeach
    </select>
</div>

<div id="app" class="form-group">
    <label><b>Start</b></label>
    <div class="startTime input-group">
        <start-time></start-time>
        <button type="button" id="startButton" class="btnStart btn btn-outline-danger ml-1" onclick="setStartTime()">Now</button>
    </div>
</div>

<div id="app" class="form-group">
    <label><b>Finish</b></label>
    <div class="finishTime input-group">
        <finish-time></finish-time>
        <button type="button" id="finishButton" class="finish btn btn-outline-danger ml-1" onclick="setFinishTime()">Now</button>
    </div>
</div>

<div class="form-group">
    <label for="durationForm"><b>Duration</b></label>
    <input name="duration" id="diff" class="form-control" readonly="read-only">
</div>

<div class="form-group">
    <label for="notesForm"><b>Notes</b></label>
    <textarea name="notes" class="form-control" id="notesForm" rows="3" required="true"></textarea>
</div>

<button type="submit" id="submitButton" class="btn btn-danger">Submit</button>

@section('timetracker')
    <script src="{{ asset('js/timetracker.js') }}" defer></script>
@stop