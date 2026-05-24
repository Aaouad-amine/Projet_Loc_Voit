<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — AutoLux</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
        :root{
            --cream:#FAF7F2;--cream-2:#F3EDE3;--cream-3:#EDE4D6;
            --gold:#B8860B;--gold-light:#D4A017;--gold-dim:rgba(184,134,11,0.1);--gold-border:rgba(184,134,11,0.25);
            --dark:#1C1A16;--text:#3D3526;--text-2:#6B5F4A;--text-3:#9A8E7A;
            --white:#FFFFFF;--red:#DC2626;--green:#16a34a;
            --shadow:0 4px 24px rgba(28,26,22,0.08);--shadow-lg:0 12px 48px rgba(28,26,22,0.14);
        }
        html{height:100%;}
        body{min-height:100vh;background:var(--cream);color:var(--text);font-family:'Inter',sans-serif;font-weight:300;display:grid;grid-template-columns:1fr 1fr;}

        .left{position:relative;overflow:hidden;display:flex;flex-direction:column;justify-content:space-between;padding:2.5rem;}
        .l-bg{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1200&q=80&auto=format') center/cover no-repeat;opacity:.25;animation:lZoom 20s ease-in-out infinite alternate;}
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
        .l-title{font-family:'Playfair Display',serif;font-size:clamp(1.8rem,3.5vw,2.6rem);font-weight:700;line-height:1.15;margin-bottom:1rem;color:var(--white);}
        .l-title em{font-style:italic;color:var(--gold-light);}
        .l-desc{font-size:.86rem;color:rgba(250,247,242,.5);line-height:1.7;max-width:300px;margin-bottom:2rem;}
        .l-steps{display:flex;flex-direction:column;gap:1.2rem;}
        .l-step{display:flex;align-items:flex-start;gap:1rem;}
        .s-num{width:26px;height:26px;border-radius:50%;flex-shrink:0;background:rgba(184,134,11,.15);border:.5px solid rgba(184,134,11,.3);display:flex;align-items:center;justify-content:center;font-size:.62rem;font-weight:600;color:var(--gold-light);}
        .s-title{font-size:.82rem;font-weight:500;color:rgba(250,247,242,.7);margin-bottom:.1rem;}
        .s-desc{font-size:.73rem;color:rgba(250,247,242,.3);}
        .l-foot{position:relative;z-index:2;font-size:.7rem;color:rgba(250,247,242,.2);}

        .right{display:flex;align-items:center;justify-content:center;padding:2rem 4rem;background:var(--white);position:relative;overflow-y:auto;}
        .right::before{content:'';position:absolute;left:0;top:8%;bottom:8%;width:1px;background:linear-gradient(to bottom,transparent,var(--cream-3),transparent);}

        .form-box{width:100%;max-width:420px;padding:.5rem 0;}
        .f-eye{font-size:.62rem;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);margin-bottom:.5rem;}
        .f-title{font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:700;margin-bottom:.4rem;color:var(--dark);}
        .f-sub{font-size:.83rem;color:var(--text-2);margin-bottom:1.8rem;}
        .f-sub a{color:var(--gold);text-decoration:none;font-weight:500;}
        .f-sub a:hover{text-decoration:underline;}

        .alert{padding:.85rem 1.1rem;border-radius:3px;font-size:.82rem;margin-bottom:1.2rem;display:flex;gap:.6rem;}
        .alert-error{background:#fef2f2;border:1px solid #fecaca;color:var(--red);}
        .alert-success{background:#f0fdf4;border:1px solid #86efac;color:var(--green);}

        /* ── ROLE SELECTOR ── */
        .role-label{font-size:.67rem;letter-spacing:.15em;text-transform:uppercase;color:var(--text-2);margin-bottom:.55rem;display:block;}
        .role-picker{display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:1.3rem;}
        .role-card{position:relative;cursor:pointer;}
        .role-card input[type=radio]{position:absolute;opacity:0;width:0;height:0;}
        .role-card-inner{
            border:1.5px solid var(--cream-3);border-radius:6px;padding:.9rem .8rem;
            display:flex;flex-direction:column;align-items:center;gap:.45rem;
            background:var(--cream);transition:all .25s;text-align:center;
        }
        .role-card input:checked + .role-card-inner{
            border-color:var(--gold);background:rgba(184,134,11,.06);
            box-shadow:0 0 0 3px rgba(184,134,11,.1);
        }
        .role-card-inner:hover{border-color:var(--gold-light);}
        .role-icon{font-size:1.5rem;line-height:1;}
        .role-name{font-size:.78rem;font-weight:600;color:var(--dark);}
        .role-hint{font-size:.65rem;color:var(--text-3);line-height:1.4;}
        .role-check{
            position:absolute;top:.5rem;right:.5rem;width:16px;height:16px;
            border-radius:50%;border:1.5px solid var(--cream-3);background:var(--white);
            display:flex;align-items:center;justify-content:center;
            transition:all .25s;font-size:.55rem;color:transparent;
        }
        .role-card input:checked ~ .role-card-inner .role-check{
            background:var(--gold);border-color:var(--gold);color:var(--white);
        }

        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
        .field{margin-bottom:1.1rem;}
        .field label{display:block;font-size:.67rem;letter-spacing:.15em;text-transform:uppercase;color:var(--text-2);margin-bottom:.4rem;}
        .iw{position:relative;}
        .iw>svg:first-child{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);width:14px;height:14px;stroke:var(--text-3);fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;pointer-events:none;transition:stroke .3s;}
        .field input{width:100%;padding:.78rem 1rem .78rem 2.5rem;background:var(--cream);border:1px solid var(--cream-3);color:var(--text);font-family:'Inter',sans-serif;font-size:.86rem;font-weight:400;outline:none;transition:all .3s;border-radius:3px;}
        .field input:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(184,134,11,.07);background:var(--white);}
        .iw:focus-within>svg:first-child{stroke:var(--gold);}
        .field input::placeholder{color:var(--text-3);}
        .field input.err{border-color:#fca5a5;background:#fef2f2;}
        .field-err{font-size:.7rem;color:var(--red);margin-top:.3rem;}

        .pw-toggle{position:absolute;right:.9rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-3);transition:color .3s;padding:0;display:flex;}
        .pw-toggle:hover{color:var(--gold);}
        .pw-toggle svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;}

        .pw-strength{margin-top:.45rem;}
        .pw-bar{height:3px;background:var(--cream-3);border-radius:2px;overflow:hidden;margin-bottom:.25rem;}
        .pw-fill{height:100%;width:0;border-radius:2px;transition:width .4s,background .4s;}
        .pw-hint{font-size:.67rem;color:var(--text-3);}

        .terms{display:flex;align-items:flex-start;gap:.65rem;margin-bottom:1.4rem;}
        .terms input[type=checkbox]{width:15px;height:15px;flex-shrink:0;margin-top:2px;appearance:none;background:var(--cream);border:1px solid var(--cream-3);border-radius:2px;cursor:pointer;position:relative;transition:all .2s;}
        .terms input:checked{background:var(--gold);border-color:var(--gold);}
        .terms input:checked::after{content:'✓';position:absolute;color:var(--white);font-size:.6rem;font-weight:700;top:50%;left:50%;transform:translate(-50%,-50%);}
        .terms span{font-size:.78rem;color:var(--text-2);line-height:1.5;}
        .terms a{color:var(--gold);text-decoration:none;}
        .terms a:hover{text-decoration:underline;}

        .btn-submit{width:100%;padding:.9rem;background:var(--gold);color:var(--white);font-family:'Inter',sans-serif;font-size:.78rem;letter-spacing:.12em;text-transform:uppercase;font-weight:600;border:none;cursor:pointer;border-radius:3px;display:flex;align-items:center;justify-content:center;gap:.7rem;transition:all .3s;}
        .btn-submit:hover{background:var(--gold-light);box-shadow:0 8px 24px rgba(184,134,11,.35);transform:translateY(-1px);}
        .btn-submit svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}

        .divider{display:flex;align-items:center;gap:1rem;margin:1.3rem 0;color:var(--text-3);font-size:.72rem;}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--cream-3);}
        .login-cta{text-align:center;font-size:.82rem;color:var(--text-2);}
        .login-cta a{color:var(--gold);text-decoration:none;font-weight:500;}
        .login-cta a:hover{text-decoration:underline;}

        @media(max-width:768px){body{grid-template-columns:1fr;}.left{display:none;}.right{padding:2rem 1.5rem;}.right::before{display:none;}.form-row{grid-template-columns:1fr;}}
    </style>
</head>
<body>

<div class="left">
    <div class="l-bg"></div><div class="l-ov"></div>
    <div class="orb o1"></div><div class="orb o2"></div>
    <a href="{{ route('home') }}" class="l-logo">AUTO<span>LUX</span></a>
    <div class="l-content">
        <div class="l-tag">Nouveau membre</div>
        <h2 class="l-title">Créez votre compte<br><em>AutoLux</em><br>gratuitement</h2>
        <p class="l-desc">En 2 minutes, accédez à notre flotte premium avec des avantages exclusifs membres.</p>
        <div class="l-steps">
            <div class="l-step"><div class="s-num">1</div><div><div class="s-title">Choisissez votre rôle</div><div class="s-desc">Client ou Locataire</div></div></div>
            <div class="l-step"><div class="s-num">2</div><div><div class="s-title">Compte créé instantanément</div><div class="s-desc">Connecté automatiquement</div></div></div>
            <div class="l-step"><div class="s-num">3</div><div><div class="s-title">Réservez votre premier véhicule</div><div class="s-desc">Tarifs préférentiels dès l'inscription</div></div></div>
        </div>
    </div>
    <div class="l-foot">© {{ date('Y') }} AutoLux — Inscription 100% gratuite</div>
</div>

<div class="right">
    <div class="form-box">
        <div class="f-eye">Inscription</div>
        <h1 class="f-title">Créer un compte 🚀</h1>
        <p class="f-sub">Déjà membre ? <a href="{{ route('login') }}">Se connecter →</a></p>

        @if(session('success'))<div class="alert alert-success">✓ {{ session('success') }}</div>@endif
        @if($errors->any() && !$errors->has('nom') && !$errors->has('email') && !$errors->has('password') && !$errors->has('role'))
        <div class="alert alert-error"><span>⚠</span><div>{{ $errors->first() }}</div></div>
        @endif

        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            {{-- ── ROLE PICKER ── --}}
            <span class="role-label">Je souhaite m'inscrire en tant que</span>
            <div class="role-picker">
                <label class="role-card">
                    <input type="radio" name="role" value="client" {{ old('role','client')==='client' ? 'checked' : '' }}>
                    <div class="role-card-inner">
                        <span class="role-check">✓</span>
                        <span class="role-icon">🧑‍💼</span>
                        <span class="role-name">Client</span>
                        <span class="role-hint">Je souhaite louer un véhicule</span>
                    </div>
                </label>
                <label class="role-card">
                    <input type="radio" name="role" value="locataire" {{ old('role')==='locataire' ? 'checked' : '' }}>
                    <div class="role-card-inner">
                        <span class="role-check">✓</span>
                        <span class="role-icon">🏢</span>
                        <span class="role-name">Locataire</span>
                        <span class="role-hint">Je propose des véhicules à la location</span>
                    </div>
                </label>
            </div>
            @error('role')<div class="field-err" style="margin-top:-.8rem;margin-bottom:.8rem;">{{ $message }}</div>@enderror

            <div class="form-row">
                <div class="field">
                    <label for="nom">Nom</label>
                    <div class="iw">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" placeholder="Aaouad" class="{{ $errors->has('nom') ? 'err' : '' }}" required>
                    </div>
                    @error('nom')<div class="field-err">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label for="prenom">Prénom</label>
                    <div class="iw">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" placeholder="Amine" class="{{ $errors->has('prenom') ? 'err' : '' }}" required>
                    </div>
                    @error('prenom')<div class="field-err">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="field">
                <label for="phone">Téléphone <span style="opacity:.5;font-size:.6rem;">(optionnel)</span></label>
                <div class="iw">
                    <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.39 2 2 0 0 1 3.6 1.21h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.79a16 16 0 0 0 6.29 6.29l.95-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+212 6XX XXX XXX">
                </div>
            </div>

            <div class="field">
                <label for="email">Adresse email</label>
                <div class="iw">
                    <svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="votre@email.com" class="{{ $errors->has('email') ? 'err' : '' }}" required>
                </div>
                @error('email')<div class="field-err">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="password">Mot de passe</label>
                <div class="iw">
                    <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" id="password" name="password" placeholder="Minimum 8 caractères" oninput="checkPw(this.value)" class="{{ $errors->has('password') ? 'err' : '' }}" required>
                    <button type="button" class="pw-toggle" onclick="togglePw('password')" tabindex="-1">
                        <svg id="eye-password" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                <div class="pw-strength">
                    <div class="pw-bar"><div class="pw-fill" id="pw-fill"></div></div>
                    <span class="pw-hint" id="pw-hint">Entrez votre mot de passe</span>
                </div>
                @error('password')<div class="field-err">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <div class="iw">
                    <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Répétez votre mot de passe" required>
                    <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation')" tabindex="-1">
                        <svg id="eye-password_confirmation" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <div class="terms">
                <input type="checkbox" id="terms" name="terms" required>
                <span>J'accepte les <a href="#">conditions d'utilisation</a> et la <a href="#">politique de confidentialité</a> d'AutoLux.</span>
            </div>

            <button type="submit" class="btn-submit">
                Créer mon compte
                <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
            </button>
        </form>

        <div class="divider">déjà membre ?</div>
        <div class="login-cta"><a href="{{ route('login') }}">→ Se connecter à mon compte existant</a></div>
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
function checkPw(pw){
    const fill=document.getElementById('pw-fill'),hint=document.getElementById('pw-hint');
    let s=0;
    if(pw.length>=8)s++;if(pw.length>=12)s++;
    if(/[A-Z]/.test(pw))s++;if(/[0-9]/.test(pw))s++;if(/[^A-Za-z0-9]/.test(pw))s++;
    const lvls=[
        {w:'0%',c:'transparent',t:'Entrez votre mot de passe'},
        {w:'25%',c:'#DC2626',t:'Trop faible'},
        {w:'50%',c:'#D97706',t:'Moyen'},
        {w:'75%',c:'#CA8A04',t:'Bon'},
        {w:'100%',c:'#16a34a',t:'Excellent ! ✓'},
    ];
    const l=pw.length===0?0:Math.min(s,4);
    fill.style.width=lvls[l].w;fill.style.background=lvls[l].c;
    hint.textContent=lvls[l].t;hint.style.color=lvls[l].c||'var(--text-3)';
}
</script>
</body>
</html>