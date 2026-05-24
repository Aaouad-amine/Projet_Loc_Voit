<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoLux — Location de Voitures de Prestige</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
        :root{
            --cream:       #FAF7F2;
            --cream-2:     #F3EDE3;
            --cream-3:     #EDE4D6;
            --gold:        #B8860B;
            --gold-light:  #D4A017;
            --gold-dim:    rgba(184,134,11,0.12);
            --gold-border: rgba(184,134,11,0.25);
            --dark:        #1C1A16;
            --dark-2:      #2C2820;
            --text:        #3D3526;
            --text-2:      #6B5F4A;
            --text-3:      #9A8E7A;
            --white:       #FFFFFF;
            --shadow:      0 4px 24px rgba(28,26,22,0.08);
            --shadow-lg:   0 12px 48px rgba(28,26,22,0.12);
        }
        html{scroll-behavior:smooth;}
        body{background:var(--cream);color:var(--text);font-family:'Inter',sans-serif;font-weight:300;overflow-x:hidden;}

        /* ── LOADER ── */
        #loader{position:fixed;inset:0;z-index:9000;background:var(--cream);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:2rem;transition:opacity .7s,visibility .7s;}
        #loader.hidden{opacity:0;visibility:hidden;}
        .l-logo{font-family:'Playfair Display',serif;font-size:3rem;font-weight:700;color:var(--dark);letter-spacing:.08em;display:flex;overflow:hidden;}
        .l-logo span{display:inline-block;animation:slideUp .7s cubic-bezier(.16,1,.3,1) forwards;opacity:0;}
        .l-logo .g{color:var(--gold);}
        @keyframes slideUp{from{opacity:0;transform:translateY(60px);}to{opacity:1;transform:translateY(0);}}
        .l-bar{width:200px;height:2px;background:var(--cream-3);border-radius:2px;overflow:hidden;}
        .l-fill{height:100%;width:0;background:linear-gradient(90deg,var(--gold),var(--gold-light));animation:lFill 1.8s ease forwards;border-radius:2px;}
        @keyframes lFill{to{width:100%;}}
        .l-count{font-size:.7rem;letter-spacing:.2em;color:var(--text-3);}

        /* ── NAV ── */
        nav{position:fixed;top:0;left:0;right:0;z-index:100;padding:1.2rem 5rem;display:flex;align-items:center;justify-content:space-between;transition:all .4s;}
        nav.scrolled{background:rgba(250,247,242,0.96);backdrop-filter:blur(20px);box-shadow:0 1px 0 var(--gold-border), var(--shadow);}
        .nav-logo{font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;color:var(--dark);text-decoration:none;letter-spacing:.05em;}
        .nav-logo span{color:var(--gold);}
        .nav-links{display:flex;gap:2.5rem;list-style:none;align-items:center;}
        .nav-links a{font-size:.75rem;letter-spacing:.12em;text-transform:uppercase;color:var(--text-2);text-decoration:none;transition:color .3s;position:relative;}
        .nav-links a::after{content:'';position:absolute;bottom:-3px;left:0;right:0;height:1px;background:var(--gold);transform:scaleX(0);transform-origin:right;transition:transform .3s;}
        .nav-links a:hover{color:var(--dark);}
        .nav-links a:hover::after{transform:scaleX(1);transform-origin:left;}
        .nav-btns{display:flex;gap:.7rem;align-items:center;}
        .n-login{font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;padding:.5rem 1.3rem;border:1px solid var(--gold-border);color:var(--gold);text-decoration:none;transition:all .3s;border-radius:3px;}
        .n-login:hover{background:var(--gold-dim);border-color:var(--gold);}
        .n-register{font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;padding:.5rem 1.5rem;background:var(--gold);color:var(--white);text-decoration:none;font-weight:600;transition:all .3s;border-radius:3px;display:flex;align-items:center;gap:.5rem;}
        .n-register:hover{background:var(--gold-light);box-shadow:0 6px 20px rgba(184,134,11,0.3);transform:translateY(-1px);}
        .n-register svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}

        /* ── USER DROPDOWN ── */
        .user-menu{position:relative;}
        .user-btn{
            display:flex;align-items:center;gap:.45rem;
            background:transparent;
            border:1px solid rgba(184,134,11,.4);
            color:var(--gold-light);
            font-family:'Inter',sans-serif;
            font-size:.7rem;letter-spacing:.15em;text-transform:uppercase;font-weight:600;
            padding:.45rem .9rem;border-radius:3px;cursor:pointer;
            transition:all .25s;
        }
        .user-btn:hover,.user-btn.open{background:rgba(184,134,11,.1);border-color:var(--gold-light);}
        .user-btn .chevron{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;transition:transform .25s;flex-shrink:0;}
        .user-btn.open .chevron{transform:rotate(180deg);}

        .user-dd{
            position:absolute;top:calc(100% + .7rem);right:0;
            width:245px;
            background:var(--dark);
            border:1px solid rgba(184,134,11,.2);
            border-radius:6px;
            box-shadow:0 20px 60px rgba(0,0,0,.45);
            opacity:0;transform:translateY(-10px) scale(.97);
            pointer-events:none;
            transition:opacity .22s cubic-bezier(.4,0,.2,1),transform .22s cubic-bezier(.4,0,.2,1);
            z-index:200;overflow:hidden;
        }
        .user-dd.open{opacity:1;transform:translateY(0) scale(1);pointer-events:all;}

        /* Header du dropdown */
        .dd-head{display:flex;align-items:center;gap:.75rem;padding:.95rem 1rem;background:rgba(255,255,255,.03);}
        .dd-ava{
            width:36px;height:36px;border-radius:50%;flex-shrink:0;
            background:rgba(184,134,11,.15);border:1px solid rgba(184,134,11,.3);
            display:flex;align-items:center;justify-content:center;
            font-size:.85rem;font-weight:700;color:var(--gold-light);
        }
        .dd-fullname{font-size:.82rem;font-weight:600;color:#FAF7F2;margin-bottom:.1rem;}
        .dd-email{font-size:.65rem;color:rgba(250,247,242,.3);word-break:break-all;}
        .dd-role-tag{font-size:.6rem;color:rgba(184,134,11,.7);margin-top:.2rem;}

        .dd-sep{height:1px;background:rgba(255,255,255,.07);}

        /* Items */
        .dd-item{
            display:flex;align-items:center;gap:.65rem;
            padding:.7rem 1rem;width:100%;
            font-family:'Inter',sans-serif;font-size:.78rem;
            color:rgba(250,247,242,.6);text-decoration:none;
            background:none;border:none;cursor:pointer;text-align:left;
            transition:all .15s;
        }
        .dd-item svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0;opacity:.55;}
        .dd-item:hover{background:rgba(184,134,11,.08);color:#FAF7F2;}
        .dd-item:hover svg{opacity:1;}
        .dd-logout{color:rgba(220,38,38,.7);}
        .dd-logout:hover{background:rgba(220,38,38,.08);color:#DC2626;}

        /* ── HERO ── */
        #hero{position:relative;height:100vh;min-height:680px;display:flex;align-items:center;overflow:hidden;background:var(--dark);}
        .h-img{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=1800&q=80&auto=format') center/cover no-repeat;opacity:.35;animation:hZoom 20s ease-in-out infinite alternate;}
        @keyframes hZoom{from{transform:scale(1.02);}to{transform:scale(1.08);}}
        .h-ov{position:absolute;inset:0;background:linear-gradient(105deg,rgba(28,26,22,.92) 35%,rgba(28,26,22,.5) 70%,rgba(28,26,22,.2));}
        .h-ov-bot{position:absolute;bottom:0;left:0;right:0;height:30%;background:linear-gradient(to top,var(--cream),transparent);}
        .h-lines{position:absolute;inset:0;background-image:linear-gradient(rgba(184,134,11,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(184,134,11,.03) 1px,transparent 1px);background-size:70px 70px;}
        .h-content{position:relative;z-index:2;padding:0 5rem;max-width:820px;}
        .h-badge{display:inline-flex;align-items:center;gap:.7rem;background:rgba(184,134,11,.15);border:.5px solid rgba(184,134,11,.4);padding:.38rem 1rem;border-radius:100px;margin-bottom:2rem;opacity:0;animation:fadeUp .7s ease 2s forwards;}
        .h-badge-dot{width:6px;height:6px;border-radius:50%;background:var(--gold-light);animation:pulse 2s ease infinite;}
        @keyframes pulse{0%,100%{opacity:1;}50%{opacity:.3;}}
        .h-badge span{font-size:.65rem;letter-spacing:.15em;text-transform:uppercase;color:var(--gold-light);}
        .h-title{font-family:'Playfair Display',serif;font-size:clamp(3rem,7vw,6rem);font-weight:700;line-height:1.05;margin-bottom:1.8rem;color:var(--white);}
        .h-tl{overflow:hidden;display:block;}
        .h-ti{display:block;transform:translateY(110%);animation:lReveal .9s cubic-bezier(.16,1,.3,1) forwards;}
        .h-tl:nth-child(1) .h-ti{animation-delay:2.1s;}
        .h-tl:nth-child(2) .h-ti{animation-delay:2.25s;}
        .h-tl:nth-child(3) .h-ti{animation-delay:2.4s;}
        @keyframes lReveal{to{transform:translateY(0);}}
        .h-title em{font-style:italic;color:var(--gold-light);}
        .h-sub{font-size:1rem;color:rgba(250,247,242,.65);line-height:1.75;max-width:440px;margin-bottom:2.5rem;opacity:0;animation:fadeUp .7s ease 2.7s forwards;}
        @keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
        .h-actions{display:flex;gap:1rem;flex-wrap:wrap;opacity:0;animation:fadeUp .7s ease 2.9s forwards;}
        .btn-primary{padding:.9rem 2.2rem;background:var(--gold);color:var(--white);font-size:.78rem;letter-spacing:.1em;text-transform:uppercase;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:.7rem;transition:all .3s;border-radius:3px;}
        .btn-primary:hover{background:var(--gold-light);transform:translateY(-2px);box-shadow:0 12px 30px rgba(184,134,11,.4);}
        .btn-primary svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}
        .btn-outline-light{padding:.9rem 2rem;border:1px solid rgba(250,247,242,.3);color:rgba(250,247,242,.8);font-size:.78rem;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;display:inline-flex;align-items:center;gap:.7rem;transition:all .3s;border-radius:3px;}
        .btn-outline-light:hover{background:rgba(250,247,242,.08);border-color:rgba(250,247,242,.6);color:var(--white);}
        .btn-register-hero{padding:.9rem 2rem;border:1px solid rgba(184,134,11,.5);color:var(--gold-light);font-size:.78rem;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;display:inline-flex;align-items:center;gap:.65rem;transition:all .3s;border-radius:3px;font-weight:500;}
        .btn-register-hero:hover{background:rgba(184,134,11,.15);border-color:var(--gold-light);transform:translateY(-2px);}
        .btn-register-hero svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}
        .h-scroll{position:absolute;bottom:6rem;left:50%;transform:translateX(-50%);display:flex;flex-direction:column;align-items:center;gap:.6rem;opacity:0;animation:fadeUp .7s ease 3.3s forwards;}
        .scroll-mouse{width:22px;height:34px;border:1px solid rgba(184,134,11,.4);border-radius:11px;display:flex;justify-content:center;padding-top:6px;}
        .scroll-mouse::before{content:'';width:3px;height:7px;background:var(--gold);border-radius:2px;animation:sDrop 2s ease infinite;}
        @keyframes sDrop{0%{opacity:1;transform:translateY(0);}100%{opacity:0;transform:translateY(10px);}}
        .scroll-text{font-size:.58rem;letter-spacing:.2em;text-transform:uppercase;color:rgba(184,134,11,.6);}

        /* ── SEARCH BAR ── */
        .search-wrap{padding:0 5rem;margin-top:-36px;position:relative;z-index:10;}
        .search-bar{background:var(--white);border:1px solid var(--cream-3);display:flex;align-items:stretch;box-shadow:var(--shadow-lg);border-radius:4px;overflow:hidden;}
        .sf{flex:1;padding:1.3rem 1.6rem;border-right:1px solid var(--cream-3);display:flex;flex-direction:column;gap:.3rem;}
        .sf:last-of-type{border-right:none;}
        .sf label{font-size:.58rem;letter-spacing:.18em;text-transform:uppercase;color:var(--gold);}
        .sf input,.sf select{background:none;border:none;outline:none;color:var(--text);font-family:'Inter',sans-serif;font-size:.88rem;font-weight:400;width:100%;}
        .sf select option{background:var(--white);}
        .sf input::placeholder{color:var(--text-3);}
        .search-btn{padding:0 2.5rem;background:var(--gold);color:var(--white);border:none;cursor:pointer;font-size:.7rem;letter-spacing:.15em;text-transform:uppercase;font-weight:600;white-space:nowrap;transition:background .3s;display:flex;align-items:center;gap:.5rem;}
        .search-btn:hover{background:var(--gold-light);}
        .search-btn svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2.5;stroke-linecap:round;}

        /* ── STATS ── */
        .stats-band{display:grid;grid-template-columns:repeat(4,1fr);background:var(--white);border-top:1px solid var(--cream-3);border-bottom:1px solid var(--cream-3);margin-top:2.5rem;}
        .stat{padding:2.5rem 2rem;text-align:center;border-right:1px solid var(--cream-3);position:relative;overflow:hidden;transition:background .3s;}
        .stat:hover{background:var(--cream);}
        .stat:last-child{border-right:none;}
        .stat::before{content:'';position:absolute;top:0;left:25%;right:25%;height:2px;background:var(--gold);opacity:0;transition:opacity .4s;}
        .stat:hover::before{opacity:1;}
        .stat-num{font-family:'Playfair Display',serif;font-size:3rem;font-weight:700;color:var(--gold);line-height:1;margin-bottom:.3rem;}
        .stat-lbl{font-size:.65rem;letter-spacing:.15em;text-transform:uppercase;color:var(--text-3);}

        /* ── SECTION ── */
        .section{padding:6rem 5rem;}
        .s-tag{font-size:.63rem;letter-spacing:.25em;text-transform:uppercase;color:var(--gold);margin-bottom:.7rem;display:flex;align-items:center;gap:.7rem;}
        .s-tag::before{content:'';width:18px;height:1px;background:var(--gold);}
        .s-title{font-family:'Playfair Display',serif;font-size:clamp(2rem,4vw,3.2rem);font-weight:700;line-height:1.15;color:var(--dark);}
        .s-title em{font-style:italic;color:var(--gold);}

        /* ── REGISTER BANNER ── */
        .reg-banner{margin:0 5rem;background:linear-gradient(105deg,var(--dark) 0%,var(--dark-2) 100%);padding:3rem 3.5rem;display:flex;align-items:center;justify-content:space-between;gap:2rem;position:relative;overflow:hidden;border-radius:4px;}
        .reg-banner::before{content:'';position:absolute;top:0;left:0;bottom:0;width:4px;background:linear-gradient(to bottom,var(--gold),rgba(184,134,11,.1));}
        .reg-banner::after{content:'';position:absolute;top:-50%;right:-10%;width:300px;height:300px;border-radius:50%;background:rgba(184,134,11,.04);pointer-events:none;}
        .reg-banner h3{font-family:'Playfair Display',serif;font-size:1.7rem;font-weight:700;color:var(--white);margin-bottom:.4rem;}
        .reg-banner p{font-size:.85rem;color:rgba(250,247,242,.5);line-height:1.5;}
        .reg-actions{display:flex;gap:.8rem;flex-shrink:0;}
        .btn-reg-big{padding:.9rem 2.2rem;background:var(--gold);color:var(--white);font-size:.76rem;letter-spacing:.1em;text-transform:uppercase;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:.6rem;transition:all .3s;border-radius:3px;}
        .btn-reg-big:hover{background:var(--gold-light);box-shadow:0 8px 24px rgba(184,134,11,.4);transform:translateY(-2px);}
        .btn-reg-big svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}
        .btn-log-big{padding:.9rem 2rem;border:1px solid rgba(250,247,242,.2);color:rgba(250,247,242,.6);font-size:.76rem;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;display:inline-flex;align-items:center;gap:.6rem;transition:all .3s;border-radius:3px;}
        .btn-log-big:hover{color:var(--white);border-color:rgba(250,247,242,.5);}

        /* ── VOITURES ── */
        .v-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;}
        .v-card{background:var(--white);border-radius:4px;overflow:hidden;box-shadow:var(--shadow);transition:all .4s;position:relative;cursor:pointer;}
        .v-card:hover{transform:translateY(-6px);box-shadow:var(--shadow-lg);}
        .v-card:first-child{grid-column:span 2;}
        .v-img{height:240px;background-size:cover;background-position:center;transition:transform .8s cubic-bezier(.25,1,.5,1);position:relative;overflow:hidden;}
        .v-card:first-child .v-img{height:320px;}
        .v-card:hover .v-img > div{transform:scale(1.05);}
        .v-img-inner{position:absolute;inset:0;background-size:cover;background-position:center;transition:transform .8s cubic-bezier(.25,1,.5,1);}
        .v-card:nth-child(1) .v-img-inner{background-image:url('https://images.unsplash.com/photo-1555215695-3004980ad54e?w=1200&q=80&auto=format');}
        .v-card:nth-child(2) .v-img-inner{background-image:url('https://images.unsplash.com/photo-1606016159991-dfe4f2746ad5?w=800&q=80&auto=format');}
        .v-card:nth-child(3) .v-img-inner{background-image:url('https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=800&q=80&auto=format');}
        .v-card:nth-child(4) .v-img-inner{background-image:url('https://images.unsplash.com/photo-1511919884226-fd3cad34687c?w=800&q=80&auto=format');}
        .v-card:nth-child(5) .v-img-inner{background-image:url('https://images.unsplash.com/photo-1583121274602-3e2820c69888?w=800&q=80&auto=format');}
        .v-card:nth-child(6) .v-img-inner{background-image:url('https://images.unsplash.com/photo-1553440569-bcc63803a83d?w=800&q=80&auto=format');}
        .v-badge{position:absolute;top:1rem;left:1rem;font-size:.58rem;letter-spacing:.15em;text-transform:uppercase;padding:.28rem .75rem;border-radius:100px;background:rgba(184,134,11,.9);color:var(--white);font-weight:600;}
        .v-badge-ok{position:absolute;top:1rem;right:1rem;font-size:.58rem;letter-spacing:.12em;text-transform:uppercase;padding:.28rem .75rem;border-radius:100px;background:rgba(255,255,255,.9);color:#16a34a;font-weight:600;border:1px solid #16a34a;}
        .v-body{padding:1.4rem 1.5rem 1.5rem;}
        .v-brand{font-size:.6rem;letter-spacing:.2em;text-transform:uppercase;color:var(--gold);margin-bottom:.25rem;}
        .v-name{font-family:'Playfair Display',serif;font-size:1.25rem;font-weight:700;color:var(--dark);margin-bottom:.6rem;}
        .v-card:first-child .v-name{font-size:1.6rem;}
        .v-specs{display:flex;gap:1.2rem;font-size:.72rem;color:var(--text-3);margin-bottom:1rem;flex-wrap:wrap;}
        .v-footer{display:flex;align-items:center;justify-content:space-between;padding-top:1rem;border-top:1px solid var(--cream-2);}
        .v-price{font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--gold);}
        .v-price small{font-family:'Inter',sans-serif;font-size:.62rem;font-weight:400;color:var(--text-3);letter-spacing:.08em;}
        .v-btn{font-size:.68rem;letter-spacing:.12em;text-transform:uppercase;padding:.5rem 1.2rem;background:var(--gold-dim);color:var(--gold);border:1px solid var(--gold-border);border-radius:3px;text-decoration:none;transition:all .3s;font-weight:500;}
        .v-btn:hover{background:var(--gold);color:var(--white);}
        .view-all-row{display:flex;align-items:center;justify-content:center;padding:3rem 0 0;}
        .va-link{font-size:.75rem;letter-spacing:.18em;text-transform:uppercase;color:var(--gold);text-decoration:none;display:flex;align-items:center;gap:.9rem;transition:gap .3s;font-weight:500;}
        .va-link:hover{gap:1.3rem;}
        .va-line{width:32px;height:1px;background:var(--gold);transition:width .3s;}
        .va-link:hover .va-line{width:50px;}

        /* ── PROCESS ── */
        .p-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:2rem;}
        .p-step{background:var(--white);padding:2.5rem 2rem;border-radius:4px;box-shadow:var(--shadow);position:relative;overflow:hidden;transition:all .4s;}
        .p-step:hover{transform:translateY(-4px);box-shadow:var(--shadow-lg);}
        .p-step::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--gold),var(--gold-light));opacity:0;transition:opacity .4s;}
        .p-step:hover::before{opacity:1;}
        .p-num{font-family:'Playfair Display',serif;font-size:4.5rem;font-weight:700;color:rgba(184,134,11,.08);line-height:1;margin-bottom:1.2rem;}
        .p-ico{width:44px;height:44px;border:1px solid var(--gold-border);display:flex;align-items:center;justify-content:center;margin-bottom:1rem;border-radius:3px;background:var(--gold-dim);transition:all .4s;}
        .p-step:hover .p-ico{background:var(--gold);border-color:var(--gold);}
        .p-step:hover .p-ico svg{stroke:var(--white);}
        .p-ico svg{width:20px;height:20px;stroke:var(--gold);fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;transition:stroke .4s;}
        .p-title{font-family:'Playfair Display',serif;font-size:1.2rem;font-weight:700;margin-bottom:.6rem;color:var(--dark);}
        .p-desc{font-size:.8rem;color:var(--text-2);line-height:1.7;}

        /* ── TESTIMONIALS ── */
        .t-track{overflow:hidden;}
        .t-rail{display:flex;gap:1.5rem;width:max-content;animation:marquee 35s linear infinite;}
        .t-rail:hover{animation-play-state:paused;}
        @keyframes marquee{from{transform:translateX(0);}to{transform:translateX(-50%);}}
        .t-card{width:360px;flex-shrink:0;background:var(--white);padding:2rem;border-radius:4px;box-shadow:var(--shadow);border-top:3px solid var(--gold);}
        .t-stars{color:var(--gold);font-size:.85rem;letter-spacing:.15em;margin-bottom:1rem;}
        .t-text{font-family:'Playfair Display',serif;font-size:1rem;font-style:italic;line-height:1.7;margin-bottom:1.5rem;color:var(--text-2);}
        .t-author{display:flex;align-items:center;gap:.9rem;}
        .t-ava{width:38px;height:38px;border-radius:50%;background:var(--gold-dim);border:2px solid var(--gold-border);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:1rem;color:var(--gold);font-weight:700;}
        .t-name{font-size:.85rem;font-weight:600;color:var(--dark);margin-bottom:.15rem;}
        .t-role{font-size:.68rem;color:var(--text-3);}

        /* ── CTA ── */
        #cta{position:relative;overflow:hidden;padding:8rem 5rem;display:flex;align-items:center;justify-content:center;text-align:center;background:var(--dark);}
        .cta-bg-img{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1600&q=80&auto=format') center/cover no-repeat;opacity:.12;}
        .cta-ov{position:absolute;inset:0;background:radial-gradient(ellipse at center,rgba(184,134,11,.08),var(--dark) 70%);}
        .cta-content{position:relative;z-index:2;}
        .cta-tag{font-size:.62rem;letter-spacing:.3em;text-transform:uppercase;color:var(--gold);margin-bottom:1rem;}
        .cta-title{font-family:'Playfair Display',serif;font-size:clamp(2.5rem,5vw,4rem);font-weight:700;line-height:1.1;margin-bottom:1.2rem;color:var(--white);}
        .cta-title em{color:var(--gold-light);font-style:italic;}
        .cta-sub{font-size:.9rem;color:rgba(250,247,242,.5);margin-bottom:3rem;max-width:400px;margin-inline:auto;line-height:1.65;}
        .cta-acts{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;}

        /* ── FOOTER ── */
        footer{background:var(--dark-2);padding:4rem 5rem;border-top:1px solid rgba(184,134,11,.15);}
        .f-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:3rem;margin-bottom:3rem;}
        .f-logo{font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:700;margin-bottom:.7rem;color:var(--white);}
        .f-logo span{color:var(--gold);}
        .f-desc{font-size:.82rem;color:rgba(250,247,242,.35);line-height:1.7;max-width:240px;}
        .f-col-title{font-size:.62rem;letter-spacing:.2em;text-transform:uppercase;color:var(--gold);margin-bottom:1.2rem;}
        .f-links{list-style:none;display:flex;flex-direction:column;gap:.7rem;}
        .f-links a{font-size:.82rem;color:rgba(250,247,242,.35);text-decoration:none;transition:color .3s;}
        .f-links a:hover{color:var(--white);}
        .f-bot{display:flex;justify-content:space-between;align-items:center;padding-top:2rem;border-top:1px solid rgba(184,134,11,.1);font-size:.7rem;color:rgba(250,247,242,.2);}

        /* ── FLASH ── */
        .flash{position:fixed;top:5rem;right:2rem;z-index:200;padding:.9rem 1.5rem;border-radius:3px;font-size:.83rem;box-shadow:var(--shadow-lg);animation:flashIn .4s ease;max-width:380px;}
        .flash-success{background:#f0fdf4;border:1px solid #86efac;color:#166534;}
        .flash-info{background:#fefce8;border:1px solid #fde047;color:#854d0e;}
        @keyframes flashIn{from{opacity:0;transform:translateX(20px);}to{opacity:1;transform:translateX(0);}}

        /* REVEAL */
        .reveal{opacity:0;transform:translateY(30px);transition:opacity .8s ease,transform .8s ease;}
        .reveal.visible{opacity:1;transform:translateY(0);}

        @media(max-width:900px){
            nav{padding:1rem 1.5rem;}
            .nav-links{display:none;}
            #hero,.section,#cta,footer{padding-left:1.5rem;padding-right:1.5rem;}
            .search-wrap,.reg-banner{padding:0 1.5rem;margin-left:0;margin-right:0;}
            .stats-band{grid-template-columns:repeat(2,1fr);}
            .v-grid{grid-template-columns:1fr;}
            .v-card:first-child{grid-column:span 1;}
            .p-grid{grid-template-columns:1fr 1fr;}
            .f-grid{grid-template-columns:1fr;gap:2rem;}
            .search-bar{flex-direction:column;}
            .sf{border-right:none;border-bottom:1px solid var(--cream-3);}
            .search-btn{min-height:52px;}
        }
    </style>
</head>
<body>

<!-- LOADER -->
<div id="loader">
    <div class="l-logo">
        <span style="animation-delay:.05s">A</span><span style="animation-delay:.12s">U</span><span style="animation-delay:.19s">T</span><span style="animation-delay:.26s">O</span><span class="g" style="animation-delay:.42s">L</span><span class="g" style="animation-delay:.49s">U</span><span class="g" style="animation-delay:.56s">X</span>
    </div>
    <div class="l-bar"><div class="l-fill"></div></div>
    <div class="l-count" id="lcount">0%</div>
</div>

<!-- FLASH MESSAGES -->
@if(session('success'))
<div class="flash flash-success">✓ {{ session('success') }}</div>
@endif
@if(session('info'))
<div class="flash flash-info">ℹ {{ session('info') }}</div>
@endif

<!-- ════════════════════════════════════════
     NAV
════════════════════════════════════════ -->
<nav id="navbar">
    <a href="{{ route('home') }}" class="nav-logo">AUTO<span>LUX</span></a>

    <ul class="nav-links">
        <li><a href="{{ route('voitures.index') }}">Flotte</a></li>
        <li><a href="#comment">Réserver</a></li>
        <li><a href="#temoignages">Avis</a></li>
        <li><a href="#">Contact</a></li>
    </ul>

    <div class="nav-btns">
        @guest
            {{-- Visiteur : boutons connexion / inscription --}}
            <a href="{{ route('login') }}" class="n-login">Connexion</a>
            <a href="{{ route('register') }}" class="n-register">
                <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                S'inscrire
            </a>
        @else
            {{-- Utilisateur connecté : dropdown --}}
            <div class="user-menu" id="userMenu">

                <button class="user-btn" id="userBtn" onclick="toggleMenu()">
                    {{ strtoupper(Auth::user()->nom) }}
                    <svg class="chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </button>

                <div class="user-dd" id="userDd">

                    {{-- Profil --}}
                    <div class="dd-head">
                        <div class="dd-ava">{{ strtoupper(substr(Auth::user()->prenom ?? Auth::user()->nom, 0, 1)) }}</div>
                        <div>
                            <div class="dd-fullname">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                            <div class="dd-email">{{ Auth::user()->email }}</div>
                            <div class="dd-role-tag">
                                @if(Auth::user()->role === 'admin')      👑 Administrateur
                                @elseif(Auth::user()->role === 'locataire') 🏢 Locataire
                                @else                                       🧑‍💼 Client
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="dd-sep"></div>

                    {{-- Liens selon rôle --}}
                    @if(Auth::user()->role === 'admin')
                        @if(Route::has('admin.index'))
<a class="dd-link" href="{{ route('admin.index') }}">                            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                            Dashboard Admin
                        </a>
                        @endif
                        <a class="dd-item" href="{{ route('voitures.index') }}">
                            <svg viewBox="0 0 24 24"><path d="M19 17H5c-1.1 0-2-.9-2-2V7c0-1.1.9-2 2-2h14l3 4v6c0 1.1-.9 2-2 2z"/><circle cx="7.5" cy="17.5" r="2.5"/><circle cx="16.5" cy="17.5" r="2.5"/></svg>
                            Gérer les voitures
                        </a>

                    @elseif(Auth::user()->role === 'locataire')
                        @if(Route::has('dashboard'))
                        <a class="dd-item" href="{{ route('dashboard') }}">
                            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                            Mon tableau de bord
                        </a>
                        @endif
                        <a class="dd-item" href="{{ route('voitures.index') }}">
                            <svg viewBox="0 0 24 24"><path d="M19 17H5c-1.1 0-2-.9-2-2V7c0-1.1.9-2 2-2h14l3 4v6c0 1.1-.9 2-2 2z"/><circle cx="7.5" cy="17.5" r="2.5"/><circle cx="16.5" cy="17.5" r="2.5"/></svg>
                            Mes véhicules
                        </a>
                        @if(Route::has('reservations.index'))
                        <a class="dd-item" href="{{ route('reservations.index') }}">
                            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Réservations reçues
                        </a>
                        @endif

                    @else {{-- client --}}
                        @if(Route::has('dashboard'))
                        <a class="dd-item" href="{{ route('dashboard') }}">
                            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                            Mon espace
                        </a>
                        @endif
                        @if(Route::has('reservations.index'))
                        <a class="dd-item" href="{{ route('reservations.index') }}">
                            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Mes réservations
                        </a>
                        @endif
                    @endif

                    <div class="dd-sep"></div>

                    {{-- Déconnexion --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dd-item dd-logout">
                            <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Se déconnecter
                        </button>
                    </form>

                </div><!-- /user-dd -->
            </div><!-- /user-menu -->
        @endauth
    </div>
</nav>

<!-- HERO -->
<section id="hero">
    <div class="h-img"></div>
    <div class="h-ov"></div>
    <div class="h-ov-bot"></div>
    <div class="h-lines"></div>
    <div class="h-content">
        <div class="h-badge">
            <div class="h-badge-dot"></div>
            <span>Flotte disponible dès aujourd'hui</span>
        </div>
        <h1 class="h-title">
            <span class="h-tl"><span class="h-ti">L'élégance</span></span>
            <span class="h-tl"><span class="h-ti">au <em>volant</em>,</span></span>
            <span class="h-tl"><span class="h-ti">sans compromis.</span></span>
        </h1>
        <p class="h-sub">Des véhicules haut de gamme à portée de clic. Livraison, assurance et service 24h/24 inclus.</p>
        <div class="h-actions">
            <a href="{{ route('voitures.index') }}" class="btn-primary">
                Voir la flotte
                <svg viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
            @guest
            <a href="{{ route('register') }}" class="btn-register-hero">
                <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                Créer un compte
            </a>
            @endguest
            <a href="#comment" class="btn-outline-light">Comment ça marche</a>
        </div>
    </div>
    <div class="h-scroll">
        <div class="scroll-mouse"></div>
        <span class="scroll-text">Défiler</span>
    </div>
</section>

<!-- SEARCH -->
<div class="search-wrap">
    <form action="{{ route('voitures.index') }}" method="GET">
        <div class="search-bar">
            <div class="sf">
                <label>Date de départ</label>
                <input type="date" name="date_debut" min="{{ date('Y-m-d') }}">
            </div>
            <div class="sf">
                <label>Date de retour</label>
                <input type="date" name="date_fin">
            </div>
            <div class="sf">
                <label>Catégorie</label>
                <select name="categorie">
                    <option value="">Tous les véhicules</option>
                    <option>Berline de luxe</option>
                    <option>SUV premium</option>
                    <option>Sportive</option>
                    <option>Citadine</option>
                </select>
            </div>
            <div class="sf" style="border-right:none;">
                <label>Ville</label>
                <select name="ville">
                    <option value="">Toutes les villes</option>
                    <option>Casablanca</option>
                    <option>Rabat</option>
                    <option>Marrakech</option>
                    <option>Fès</option>
                    <option>Tanger</option>
                </select>
            </div>
            <button type="submit" class="search-btn">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                Rechercher
            </button>
        </div>
    </form>
</div>

<!-- STATS -->
<div class="stats-band reveal" style="margin-top:2.5rem;">
    <div class="stat"><div class="stat-num" data-target="120">0</div><div class="stat-lbl">Véhicules disponibles</div></div>
    <div class="stat"><div class="stat-num" data-target="4800">0</div><div class="stat-lbl">Clients satisfaits</div></div>
    <div class="stat"><div class="stat-num" data-target="12">0</div><div class="stat-lbl">Années d'expérience</div></div>
    <div class="stat"><div class="stat-num" data-target="6">0</div><div class="stat-lbl">Villes au Maroc</div></div>
</div>

<!-- REGISTER BANNER -->
@guest
<div class="reg-banner reveal" style="margin-top:3rem;">
    <div>
        <h3>Rejoignez AutoLux <span style="color:var(--gold-light)">gratuitement</span></h3>
        <p>Créez votre compte en 2 minutes et profitez de tarifs préférentiels, d'un historique de réservations et d'offres exclusives membres.</p>
    </div>
    <div class="reg-actions">
        <a href="{{ route('register') }}" class="btn-reg-big">
            <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
            Créer mon compte
        </a>
        <a href="{{ route('login') }}" class="btn-log-big">Se connecter →</a>
    </div>
</div>
@endguest

<!-- VOITURES -->
<section class="section" id="flotte">
    <div class="section-header reveal" style="margin-bottom:2.5rem;display:flex;align-items:flex-end;justify-content:space-between;">
        <div>
            <div class="s-tag">Notre flotte</div>
            <h2 class="s-title">Véhicules d'<em>exception</em><br>pour chaque occasion</h2>
        </div>
        <a href="{{ route('voitures.index') }}" style="font-size:.72rem;letter-spacing:.15em;text-transform:uppercase;color:var(--gold);text-decoration:none;font-weight:500;">Voir tout →</a>
    </div>
    <div class="v-grid">
        @forelse($voitures as $index => $voiture)
        <div class="v-card reveal" style="transition-delay:{{ $index * 0.07 }}s">
            <div class="v-img">
                @if($voiture->image ?? false)
                    <div class="v-img-inner" style="background-image:url('{{ asset('storage/'.$voiture->image) }}')"></div>
                @else
                    <div class="v-img-inner"></div>
                @endif
                @if($voiture->categorie ?? false)<div class="v-badge">{{ $voiture->categorie }}</div>@endif
                @if($voiture->assurance)<div class="v-badge-ok">✓ Assuré</div>@endif
            </div>
            <div class="v-body">
                <div class="v-brand">{{ $voiture->marque ?? 'AutoLux' }}</div>
                <div class="v-name">{{ $voiture->modele }}</div>
                <div class="v-specs">
                    @if($voiture->annee ?? false)<span>📅 {{ $voiture->annee }}</span>@endif
                    @if($voiture->carburant ?? false)<span>⛽ {{ $voiture->carburant }}</span>@endif
                    @if($voiture->places ?? false)<span>👤 {{ $voiture->places }} places</span>@endif
                    @if($voiture->transmission ?? false)<span>⚙️ {{ $voiture->transmission }}</span>@endif
                </div>
                <div class="v-footer">
                    @if($voiture->prix_journalier ?? false)
                    <div class="v-price">{{ number_format($voiture->prix_journalier,0,',',' ') }} MAD <small>/ jour</small></div>
                    @else
                    <div class="v-price" style="font-size:1rem;color:var(--text-3);">Sur demande</div>
                    @endif
                    <a href="#" class="v-btn">Réserver</a>
                </div>
            </div>
        </div>
        @empty
        @for($i=1;$i<=6;$i++)
        <div class="v-card reveal" style="transition-delay:{{ ($i-1)*0.07 }}s">
            <div class="v-img"><div class="v-img-inner"></div></div>
            <div class="v-body">
                <div class="v-brand">AutoLux</div>
                <div class="v-name">Véhicule Premium {{ $i }}</div>
                <div class="v-footer"><div class="v-price" style="font-size:1rem;color:var(--text-3);">Bientôt disponible</div></div>
            </div>
        </div>
        @endfor
        @endforelse
    </div>
    <div class="view-all-row reveal">
        <a href="{{ route('voitures.index') }}" class="va-link">
            <span class="va-line"></span>Voir toute la flotte<span class="va-line"></span>
        </a>
    </div>
</section>

<!-- COMMENT ÇA MARCHE -->
<section class="section" id="comment" style="background:var(--cream-2);padding-top:5rem;padding-bottom:5rem;">
    <div class="section-header reveal" style="margin-bottom:3rem;">
        <div class="s-tag">Processus</div>
        <h2 class="s-title">Réservez en <em>4 étapes simples</em></h2>
    </div>
    <div class="p-grid">
        <div class="p-step reveal">
            <span class="p-num">01</span>
            <div class="p-ico"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg></div>
            <div class="p-title">Choisissez</div>
            <p class="p-desc">Parcourez notre flotte et filtrez par catégorie, prix ou disponibilité.</p>
        </div>
        <div class="p-step reveal" style="transition-delay:.1s">
            <span class="p-num">02</span>
            <div class="p-ico"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
            <div class="p-title">Planifiez</div>
            <p class="p-desc">Sélectionnez vos dates. Calendrier mis à jour en temps réel.</p>
        </div>
        <div class="p-step reveal" style="transition-delay:.2s">
            <span class="p-num">03</span>
            <div class="p-ico"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
            <div class="p-title">Confirmez</div>
            <p class="p-desc">Paiement sécurisé et confirmation immédiate par email et SMS.</p>
        </div>
        <div class="p-step reveal" style="transition-delay:.3s">
            <span class="p-num">04</span>
            <div class="p-ico"><svg viewBox="0 0 24 24"><path d="M19 17H5c-1.1 0-2-.9-2-2V7c0-1.1.9-2 2-2h14l3 4v6c0 1.1-.9 2-2 2z"/><circle cx="7.5" cy="17.5" r="2.5"/><circle cx="16.5" cy="17.5" r="2.5"/></svg></div>
            <div class="p-title">Profitez</div>
            <p class="p-desc">Récupérez votre véhicule impeccable. Assistance 24h/24.</p>
        </div>
    </div>
</section>

<!-- TÉMOIGNAGES -->
<section class="section" id="temoignages" style="padding-left:0;padding-right:0;background:var(--cream);">
    <div class="section-header reveal" style="padding:0 5rem;margin-bottom:2.5rem;">
        <div class="s-tag">Témoignages</div>
        <h2 class="s-title">Ils nous font <em>confiance</em></h2>
    </div>
    @php
    $tms=[
        ['note'=>5,'texte'=>'Une expérience remarquable. La Mercedes était impeccable, service d\'une élégance rare.','nom'=>'Karim B.','role'=>'Directeur, Casablanca'],
        ['note'=>5,'texte'=>'La Porsche était en parfait état. Livraison ponctuelle, personnel discret et professionnel.','nom'=>'Sophie M.','role'=>'Avocate, Rabat'],
        ['note'=>5,'texte'=>'Je recommande vivement. Rapport qualité-prestige imbattable au Maroc.','nom'=>'Youssef A.','role'=>'Entrepreneur, Marrakech'],
        ['note'=>5,'texte'=>'Troisième location cette année, toujours aussi satisfait. Véhicules entretenus avec soin.','nom'=>'Nadia R.','role'=>'Médecin, Fès'],
        ['note'=>5,'texte'=>'Réservation en 3 min, clés en main à l\'aéroport. Logistique parfaite.','nom'=>'Thomas L.','role'=>'Consultant, Paris'],
        ['note'=>5,'texte'=>'La BMW Série 7 était somptueuse. Voyage professionnel transformé en plaisir.','nom'=>'Amina K.','role'=>'CEO, Tanger'],
    ];
    @endphp
    <div class="t-track">
        <div class="t-rail">
            @foreach(array_merge($tms,$tms) as $t)
            <div class="t-card">
                <div class="t-stars">{{ str_repeat('★',$t['note']) }}</div>
                <p class="t-text">« {{ $t['texte'] }} »</p>
                <div class="t-author">
                    <div class="t-ava">{{ substr($t['nom'],0,1) }}</div>
                    <div><div class="t-name">{{ $t['nom'] }}</div><div class="t-role">{{ $t['role'] }}</div></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section id="cta">
    <div class="cta-bg-img"></div>
    <div class="cta-ov"></div>
    <div class="cta-content reveal">
        <p class="cta-tag">Prêt à prendre la route ?</p>
        <h2 class="cta-title">Votre prochaine aventure<br>commence <em>maintenant</em></h2>
        <p class="cta-sub">Rejoignez des milliers de clients qui nous font confiance. Livraison offerte dans les grandes villes.</p>
        <div class="cta-acts">
            <a href="{{ route('voitures.index') }}" class="btn-primary">
                Réserver un véhicule
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
            @guest
            <a href="{{ route('register') }}" class="btn-reg-big">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                Créer un compte gratuit
            </a>
            @endguest
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="f-grid">
        <div>
            <div class="f-logo">AUTO<span>LUX</span></div>
            <p class="f-desc">L'excellence automobile au service de vos déplacements. Flotte premium, service irréprochable.</p>
        </div>
        <div>
            <div class="f-col-title">Navigation</div>
            <ul class="f-links">
                <li><a href="{{ route('voitures.index') }}">Notre flotte</a></li>
                <li><a href="#comment">Comment réserver</a></li>
                <li><a href="#temoignages">Avis clients</a></li>
            </ul>
        </div>
        <div>
            <div class="f-col-title">Compte</div>
            <ul class="f-links">
                @guest
                <li><a href="{{ route('login') }}">Connexion</a></li>
                <li><a href="{{ route('register') }}">Inscription gratuite</a></li>
                @else
                @if(Route::has('dashboard'))<li><a href="{{ route('dashboard') }}">Mon espace</a></li>@endif
                @if(Route::has('reservations.index'))<li><a href="{{ route('reservations.index') }}">Mes réservations</a></li>@endif
                @endauth
            </ul>
        </div>
        <div>
            <div class="f-col-title">Contact</div>
            <ul class="f-links">
                <li><a href="tel:+212600000000">+212 600 000 000</a></li>
                <li><a href="mailto:contact@autolux.ma">contact@autolux.ma</a></li>
                <li><a href="#">Casablanca · Rabat · Marrakech</a></li>
            </ul>
        </div>
    </div>
    <div class="f-bot">
        <span>© {{ date('Y') }} AutoLux — Tous droits réservés</span>
        <span style="color:rgba(184,134,11,.4);">Conçu avec passion au Maroc 🇲🇦</span>
    </div>
</footer>

<script>
// ── LOADER
let c=0;const ce=document.getElementById('lcount');
const iv=setInterval(()=>{c=Math.min(c+Math.floor(Math.random()*10)+4,100);ce.textContent=c+'%';if(c>=100){clearInterval(iv);setTimeout(()=>document.getElementById('loader').classList.add('hidden'),400);}},55);

// ── NAV scroll
window.addEventListener('scroll',()=>document.getElementById('navbar').classList.toggle('scrolled',window.scrollY>60));

// ── USER DROPDOWN
function toggleMenu(){
    const btn=document.getElementById('userBtn');
    const dd=document.getElementById('userDd');
    const open=dd.classList.toggle('open');
    btn.classList.toggle('open',open);
}
// Fermer si clic en dehors
document.addEventListener('click',function(e){
    const m=document.getElementById('userMenu');
    if(m && !m.contains(e.target)){
        document.getElementById('userBtn')?.classList.remove('open');
        document.getElementById('userDd')?.classList.remove('open');
    }
});

// ── REVEAL
const obs=new IntersectionObserver(e=>{e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('visible');obs.unobserve(x.target);}});},{threshold:.07});
document.querySelectorAll('.reveal').forEach(el=>obs.observe(el));

// ── COUNT UP
const so=new IntersectionObserver(e=>{e.forEach(x=>{if(!x.isIntersecting)return;const el=x.target,t=parseInt(el.dataset.target);let st=0;const d=2000,s=ts=>{if(!st)st=ts;const p=Math.min((ts-st)/d,1),e2=1-Math.pow(1-p,4);el.textContent=Math.floor(e2*t).toLocaleString('fr');if(p<1)requestAnimationFrame(s);else el.textContent=t.toLocaleString('fr')+(t===120||t===4800?'+':'');};requestAnimationFrame(s);so.unobserve(el);});},{threshold:.5});
document.querySelectorAll('[data-target]').forEach(el=>so.observe(el));

// ── AUTO-HIDE FLASH
setTimeout(()=>document.querySelectorAll('.flash').forEach(f=>f.style.opacity='0'),4000);
</script>
</body>
</html>