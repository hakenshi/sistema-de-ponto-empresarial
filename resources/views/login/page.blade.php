<x-layout :css="asset('css/login-style.css')">

    <main>
            <div class="form-container">
                <form class="login-form" method="post" action="{{ route('login.post') }}">
                    @csrf
                    <div class="form-header">
                        <p><img class="logo" src="https://www.fae.br/unifae2/wp-content/uploads/2022/01/1625239632883-logo-unifae-2021.png" alt=""></p>
                        <p>EMBAIXADORES</p>
                    </div>
                    <div class="input">
                        <i class="fa-solid fa-user"></i>
                        <input name="email" type="text" placeholder="Email">
                    </div>
                    <div class="input">
                        <i class="fa-solid fa-lock"></i>
                        <input name="password" type="password" placeholder="•••••••">
                    </div>
                    <div>
                        <button class="button-primary" type="submit">ENTRAR</button>
                    </div>
                </form>
            </div>
    </main>
</x-layout>