<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — AutoLux</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
        :root{
            --cream:#FAF7F2;--cream-2:#F3EDE3;--cream-3:#EDE4D6;
            --gold:#B8860B;--gold-light:#D4A017;--gold-dim:rgba(184,134,11,0.1);--gold-border:rgba(184,134,11,0.25);
            --dark:#1C1A16;--dark-2:#2C2820;--text:#3D3526;--text-2:#6B5F4A;--text-3:#9A8E7A;
            --white:#FFFFFF;--red:#DC2626;--green:#16a34a;
            --shadow:0 4px 24px rgba(28,26,22,0.08);--shadow-lg:0 12px 48px rgba(28,26,22,0.14);
        }
        html{height:100%;}
        body{min-height:100vh;background:var(--cream);color:var(--text);font-family:'Inter',sans-serif;font-weight:300;display:grid;grid-template-columns:1fr 1fr;}

        /* LEFT */
        .left{position:relative;overflow:hidden;display:flex;flex-direction:column;justify-content:space-between;padding:2.5rem;}
        .l-bg{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1544636331-e26879cd4d9b?w=1200&q=80&auto=format') center/cover no-repeat;opacity:.25;animation:lZoom 20s ease-in-out infinite alternate;}
        @keyframes lZoom{from{transform:scale(1);}to{transform:scale(1.06);}}
        .l-ov{position:absolute;inset:0;background:linear-gradient(160deg,var(--dark) 0%,rgba(28,26,22,.6) 60%,var(--dark) 100%);}
        .orb{position:absolute;border-radius:50%;filter:blur(80px);pointer-events:none;}
        .o1{width:400px;height:400px;top:-80px;right:-80px;background:rgba(184,134,11,.08);}
        .o2{width:250px;height:250px;bottom:60px;left:-40px;background:rgba(184,134,11,.05);}

        .l-logo{position:relative;z-index:2;font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;text-decoration:none;color:var(--white);letter-spacing:.05em;}
        .l-logo span{color:var(--gold-light);}
        .l-content{position:relative;z-index:2;}
        .l-tag{font-size:.62rem;letter-spacing:.25em;text-transform:uppercase;color:var(--gold-light);margin-bottom:1rem;display:flex;align-items:center;gap:.6rem;}
        .l-tag::before{content:'';width:16px;height:1px;background:var(--gold-light);}
        .l-title{font-family:'Playfair Display',serif;font-size:clamp(2rem,4vw,3rem);font-weight:700;line-height:1.15;margin-bottom:1rem;color:var(--white);}
        .l-title em{font-style:italic;color:var(--gold-light);}
        .l-desc{font-size:.88rem;color:rgba(250,247,242,.5);line-height:1.7;max-width:300px;margin-bottom:2rem;}
        .l-feats{display:flex;flex-direction:column;gap:.8rem;}
        .l-feat{display:flex;align-items:center;gap:.8rem;font-size:.8rem;color:rgba(250,247,242,.55);}
        .l-feat-ico{width:30px;height:30px;border-radius:50%;background:rgba(184,134,11,.15);border:.5px solid rgba(184,134,11,.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.82rem;}
        .l-foot{position:relative;z-index:2;font-size:.7rem;color:rgba(250,247,242,.2);}

        /* RIGHT */
        .right{display:flex;align-items:center;justify-content:center;padding:3rem 4rem;background:var(--white);position:relative;}
        .right::before{content:'';position:absolute;left:0;top:8%;bottom:8%;width:1px;background:linear-gradient(to bottom,transparent,var(--cream-3),transparent);}

        .form-box{width:100%;max-width:400px;}
        .f-eye{font-size:.62rem;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);margin-bottom:.6rem;}
        .f-title{font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;margin-bottom:.4rem;color:var(--dark);}
        .f-sub{font-size:.83rem;color:var(--text-2);margin-bottom:2rem;}
        .f-sub a{color:var(--gold);text-decoration:none;font-weight:500;}
        .f-sub a:hover{text-decoration:underline;}

        .alert{padding:.85rem 1.1rem;border-radius:3px;font-size:.82rem;margin-bottom:1.3rem;display:flex;align-items:flex-start;gap:.6rem;}
        .alert-error{background:#fef2f2;border:1px solid #fecaca;color:var(--red);}
        .alert-success{background:#f0fdf4;border:1px solid #86efac;color:var(--green);}
        .alert-info{background:#fefce8;border:1px solid #fde68a;color:#92400e;}

        .field{margin-bottom:1.2rem;}
        .field label{display:block;font-size:.67rem;letter-spacing:.16em;text-transform:uppercase;color:var(--text-2);margin-bottom:.45rem;}
        .iw{position:relative;}
        .iw>svg:first-child{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);width:15px;height:15px;stroke:var(--text-3);fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;pointer-events:none;transition:stroke .3s;}
        .field input{width:100%;padding:.82rem 1rem .82rem 2.6rem;background:var(--cream);border:1px solid var(--cream-3);color:var(--text);font-family:'Inter',sans-serif;font-size:.88rem;font-weight:400;outline:none;transition:border-color .3s,box-shadow .3s,background .3s;border-radius:3px;}
        .field input:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(184,134,11,.08);background:var(--white);}
        .iw:focus-within>svg:first-child{stroke:var(--gold);}
        .field input::placeholder{color:var(--text-3);}
        .field input.err{border-color:#fca5a5;background:#fef2f2;}
        .field-err{font-size:.7rem;color:var(--red);margin-top:.35rem;}

        .pw-toggle{position:absolute;right:.9rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-3);transition:color .3s;padding:0;display:flex;}
        .pw-toggle:hover{color:var(--gold);}
        .pw-toggle svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;}

        .form-extras{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.6rem;}
        .cb-wrap{display:flex;align-items:center;gap:.55rem;cursor:pointer;}
        .cb-wrap input[type=checkbox]{width:15px;height:15px;appearance:none;background:var(--cream);border:1px solid var(--cream-3);border-radius:2px;cursor:pointer;position:relative;transition:all .2s;flex-shrink:0;}
        .cb-wrap input:checked{background:var(--gold);border-color:var(--gold);}
        .cb-wrap input:checked::after{content:'✓';position:absolute;color:var(--white);font-size:.6rem;font-weight:700;top:50%;left:50%;transform:translate(-50%,-50%);}
        .cb-wrap span{font-size:.78rem;color:var(--text-2);}
        .forgot{font-size:.75rem;color:var(--gold);text-decoration:none;}
        .forgot:hover{text-decoration:underline;}

        .btn-submit{width:100%;padding:.92rem;background:var(--gold);color:var(--white);font-family:'Inter',sans-serif;font-size:.78rem;letter-spacing:.12em;text-transform:uppercase;font-weight:600;border:none;cursor:pointer;border-radius:3px;display:flex;align-items:center;justify-content:center;gap:.7rem;transition:all .3s;}
        .btn-submit:hover{background:var(--gold-light);box-shadow:0 8px 24px rgba(184,134,11,.35);transform:translateY(-1px);}
        .btn-submit svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}

        .divider{display:flex;align-items:center;gap:1rem;margin:1.5rem 0;color:var(--text-3);font-size:.72rem;}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--cream-3);}

        .reg-prompt{text-align:center;padding:1.2rem;background:var(--cream);border:1px solid var(--cream-3);border-radius:3px;}
        .reg-prompt p{font-size:.82rem;color:var(--text-2);margin-bottom:.7rem;}
        .btn-reg-outline{display:inline-flex;align-items:center;gap:.5rem;padding:.65rem 1.8rem;border:1px solid var(--gold-border);color:var(--gold);font-size:.74rem;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;font-weight:500;transition:all .3s;border-radius:3px;}
        .btn-reg-outline:hover{background:var(--gold-dim);border-color:var(--gold);}
        .btn-reg-outline svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}

        @media(max-width:768px){body{grid-template-columns:1fr;}.left{display:none;}.right{padding:2rem 1.5rem;}.right::before{display:none;}}
    </style>
</head>
<body>

<div class="left">
    <div class="l-bg"></div><div class="l-ov"></div>
    <div class="orb o1"></div><div class="orb o2"></div>
    <a href="{{ route('home') }}" class="l-logo">AUTO<span>LUX</span></a>
    <div class="l-content">
        <div class="l-tag">Espace membre</div>
        <h2 class="l-title">Retrouvez vos<br><em>avantages</em><br>exclusifs</h2>
        <p class="l-desc">Accédez à votre historique, vos réservations en cours et les offres réservées aux membres.</p>
        <div class="l-feats">
            <div class="l-feat"><div class="l-feat-ico">⚡</div>Réservation en moins de 3 minutes</div>
            <div class="l-feat"><div class="l-feat-ico">🚗</div>120+ véhicules premium disponibles</div>
            <div class="l-feat"><div class="l-feat-ico">🛡️</div>Assurance et assistance 24h/24</div>
            <div class="l-feat"><div class="l-feat-ico">🎁</div>Tarifs préférentiels membres</div>
        </div>
    </div>
    <div class="l-foot">© {{ date('Y') }} AutoLux — Tous droits réservés</div>
</div>

<div class="right">
    <div class="form-box">
        <div class="f-eye">Connexion</div>
        <h1 class="f-title">Bon retour 👋</h1>
        <p class="f-sub">Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte gratuit →</a></p>

        @if(session('success'))<div class="alert alert-success">✓ {{ session('success') }}</div>@endif
        @if(session('info'))<div class="alert alert-info">ℹ {{ session('info') }}</div>@endif

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf
            <div class="field">
                <label for="email">Adresse email</label>
                <div class="iw">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="votre@email.com" autocomplete="email" class="{{ $errors->has('email') ? 'err' : '' }}" required>
                    <svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                </div>
                @error('email')<div class="field-err">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="password">Mot de passe</label>
                <div class="iw">
                    <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" class="{{ $errors->has('password') ? 'err' : '' }}" required>
                    <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <button type="button" class="pw-toggle" onclick="togglePw('password')" tabindex="-1">
                        <svg id="eye-password" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                @error('password')<div class="field-err">{{ $message }}</div>@enderror
            </div>

            <div class="form-extras">
                <label class="cb-wrap">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Se souvenir de moi</span>
                </label>
                <a href="#" class="forgot">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn-submit">
                Se connecter
                <svg viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            </button>
        </form>

        <div class="divider">ou</div>

        <div class="reg-prompt">
            <p>Nouveau sur AutoLux ? Rejoignez-nous gratuitement.</p>
            <a href="{{ route('register') }}" class="btn-reg-outline">
                <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                Créer mon compte
            </a>
        </div>
    </div>
</div>

<script>
function togglePw(id){
    const inp=document.getElementById(id),show=inp.type==='password';
    inp.type=show?'text':'password';
    document.getElementById('eye-'+id).innerHTML=show
        ?'<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
        :'<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
}
</script>
</body>
</html>