<x-layout>
  <x-form title="Register Now!" description="Create an account to get started">
    <form action="/register" method="POST" class="mb-10 space-y-4">
      @csrf
      <x-form.field name='name' label='Name' type='text' />
      <x-form.field name='email' label='Email' type='email' />
      <x-form.field name='password' label='Password' type='password' />
      <button type="submit" class="btn btn-primary mt-4 h-10 w-full">Create Account</button>
    </form>
    </x-form>

</x-layout>