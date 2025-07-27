<form method="POST" action="/install/env">
    @csrf
    <input name="db_host" placeholder="DB Host" required>
    <input name="db_name" placeholder="DB Name" required>
    <input name="db_user" placeholder="DB Username" required>
    <input name="db_pass" placeholder="DB Password">
    <button type="submit">Save & Continue</button>
</form>
