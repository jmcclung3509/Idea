<x-layout>
  <x-form title="Edit Profile" description="Need to make a change?">
    <form action="/profile" method="POST" class="mb-10 space-y-4">
      @csrf
      @method('PATCH')
      <x-form.field name='name' label='Name' type='text' :value="$user->name" />
      <x-form.field name='email' label='Email' type='email' :value="$user->email" />
      <x-form.field name='password' label='New Password' type='password' />
      <button type="submit" class="btn btn-primary mt-4 h-10 w-full" data-test="update-profile-button">Update Profile</button>
    </form>
    </x-form>

</x-layout>