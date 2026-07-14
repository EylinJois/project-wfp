
@csrf
@method('PUT')
<div class="form-group">
    <label for="fullname" class="form-label">Full Name</label>
    <input class="form-control" type="text" id="fullname" name="fullname" value="{{ $data->fullname }}">
    <label for="email" class="form-label">Email</label>
    <input class="form-control" type="email" id="email" name="email" value="{{ $data->email }}">
    <label for="phone" class="form-label">Phone</label>
    <input class="form-control" type="text" id="phone" name="phone" value="{{ $data->phone }}">
    <label for="sip" class="form-label">SIP</label>
    <input class="form-control" type="text" id="sip" name="sip" value="{{ $data->sip }}">
    <label for="experience" class="form-label">Experience</label>
    <input class="form-control" type="text" id="experience" name="experience" value="{{ $data->experience }}">
    <label for="photo" class="form-label">Photo</label>
    <input class="form-control" type="file" accept="image/*" id="photo" name="photo">
    <label for="specialty_id" class="form-label">Specialty</label>
    <select class="form-control" id="specialty_id" name="specialty_id">
        @foreach ($specialty as $spec)
        <option value="{{ $spec->id }}"
            {{ $spec->id == $data->specialty_id ? 'selected' : '' }}>
            {{ $spec->name }}
        </option>
        @endforeach
    </select>
    <label for="start_time" class="form-label">Start Time</label>
    <input class="form-control" type="time" id="start_time" name="start_time" value="{{ $data->start_time }}">
    <label for="end_time" class="form-label">End Time</label>
    <input class="form-control" type="time" id="end_time" name="end_time" value="{{ $data->end_time }}">
</div>
<button type="button" onClick="saveDataUpdate({{ $data->id }})" class="btn btn-primary">Submit</button>