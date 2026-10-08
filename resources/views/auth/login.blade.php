<x-layout>
  <x-form title="Login Now!" description="Login to your account to get started">
    <form action="/login" method="POST" class="mb-10 space-y-4">
      @csrf
      <x-form.field name='email' label='Email' type='email' />
      <x-form.field name='password' label='Password' type='password' />
      <button type="submit" data-test="login-button" class="btn btn-primary mt-4 h-10 w-full">Login</button>
    </form>
    </x-form>

</x-layout>