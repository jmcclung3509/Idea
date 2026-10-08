<nav class="border-b border-border px-6">
  <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
    <div class="logo">
      <a href="/"> Idea</a>
    </div>
    <div class="links flex items-end gap-4">
      @auth
      <form action="/logout" method="POST">
        @csrf
        <button type="submit" data-test="logout-button" class="btn btn-outlined">Logout</button>
      </form>
      @endauth
      @guest
      <a class="btn btn-outlined" href="/login">Login</a>
      <a class="btn btn-primary" href="/register">Register</a>
      @endguest
    </div>
    </div>
    </div>

</nav>