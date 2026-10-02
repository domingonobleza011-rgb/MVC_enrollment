<!DOCTYPE html>
<html lang="en">
<head>
<title>EPAMNHS | Vision, Mission & Core Values</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="manifest" href="manifest.php">
<link rel="icon" type="image/png" sizes="32x32" href="icons/pwa/icon-96x96.png">
<meta name="theme-color" content="#0b2b5c">

<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
/* Original palette: navy + gold, on the simpler layout */
:root{
--navy:#0b2b5c;
--navy-2:#0f3b7a;
--gold:#ffd700
}

*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{
font-family:'Inter',system-ui,-apple-system,'Segoe UI',sans-serif;
background:linear-gradient(145deg,#f8faff 0%,#f0f4fe 100%);
color:#1a2c3e;
min-height:100vh;
min-height:100dvh;
display:flex;
flex-direction:column
}

/* NAVBAR */
.navbar-custom{
background:linear-gradient(135deg,var(--navy) 0%,var(--navy-2) 100%);
position:sticky;
top:0;
z-index:1000
}
.navbar-inner{
display:flex;
align-items:center;
justify-content:space-between;
padding:.8rem 1.5rem;
gap:.75rem
}
.navbar-brand{
font-weight:700;
font-size:clamp(1rem,3.5vw,1.25rem);
letter-spacing:.02em;
color:#fff!important;
text-decoration:none;
display:flex;
align-items:center;
gap:.5rem;
flex-shrink:1;
min-width:0
}
.navbar-brand span{
overflow:hidden;
text-overflow:ellipsis;
white-space:nowrap
}
.nav-buttons{
display:flex;
gap:8px;
flex-shrink:0
}
.btn-nav{
border-radius:8px;
padding:7px 16px;
font-weight:500;
font-size:.875rem;
transition:background-color .15s;
text-decoration:none;
display:inline-flex;
align-items:center;
gap:7px;
white-space:nowrap
}
.btn-login{
background:rgba(255,255,255,.12);
border:1px solid rgba(255,255,255,.28);
color:#fff
}
.btn-login:hover{
background:rgba(255,255,255,.25);
color:#fff
}
.btn-register{
background:rgba(255,215,0,.8);
border:1px solid var(--gold);
color:var(--navy);
font-weight:600
}
.btn-register:hover{
background:var(--gold);
color:var(--navy)
}

/* HERO */
.hero{
position:relative;
width:100%;
min-height:300px;
padding:2rem 0;
overflow:hidden;
display:flex;
align-items:center;
justify-content:center;
text-align:center;
background:var(--navy)
}
.hero-bg{
position:absolute;
inset:0;
width:100%;
height:100%;
object-fit:cover;
z-index:0
}
.hero-overlay{
position:absolute;
inset:0;
background:linear-gradient(135deg,rgba(11,43,92,.65),rgba(15,59,122,.78));
z-index:1
}
.hero-content{
position:relative;
z-index:2;
padding:1rem 1.5rem
}
.school-sub{
color:rgba(255,215,0,.9);
font-size:.8rem;
letter-spacing:.08em;
text-transform:uppercase;
margin:0 0 .6rem
}
.seal-ring{
width:88px;
height:88px;
margin:0 auto .8rem;
background:#fff;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center
}
.seal-ring img{
width:100%;
height:100%;
object-fit:contain;
padding:6px;
border-radius:50%
}
.school-name{
font-size:clamp(1.3rem,4.5vw,2rem);
font-weight:700;
line-height:1.25;
color:#fff;
text-shadow:0 2px 8px rgba(0,0,0,.3);
max-width:700px;
margin:0 auto
}
.address{
font-size:.95rem;
font-weight:400;
color:#fff;
text-shadow:0 2px 8px rgba(0,0,0,.3);
margin:.4rem auto 0
}
.divider-gold{
width:70px;
height:2px;
background:linear-gradient(90deg,transparent,var(--gold),transparent);
margin:.9rem auto
}
.hero-caption{
color:rgba(255,255,255,.75);
font-size:.82rem;
letter-spacing:.04em
}

/* MAIN CONTENT */
.content{
width:100%;
max-width:1600px;
margin:0 auto;
padding:0 2rem 2rem;
flex:1 0 auto
}

/* CARDS (Vision / Mission / Core Values) */
.card-section{
display:grid;
grid-template-columns:repeat(3,minmax(0,1fr));
gap:1.5rem;
margin-top:1.5rem
}
.mv-card{
background:#fff;
border:1px solid #e2e8f0;
border-radius:12px;
box-shadow:0 2px 10px rgba(0,0,0,.06);
overflow:hidden;
display:flex;
flex-direction:column;
height:100%
}
.card-header{
padding:1rem 1.25rem;
display:flex;
align-items:center;
background:transparent;
border-bottom:1px solid #eef2f8
}
.card-label{
font-size:1.1rem;
font-weight:600;
color:var(--navy);
line-height:1.2;
margin:0
}
.card-body{
padding:1.1rem 1.25rem 1.25rem;
font-size:.95rem;
line-height:1.7;
color:#2c3e4e;
flex:1
}
.card-body p{
margin-bottom:.65rem
}
.card-body p:last-child{
margin-bottom:0
}

/* MISSION LIST */
.mission-list{
list-style:none;
padding:0;
margin:.4rem 0 0
}
.mission-list li{
position:relative;
padding-left:1.1rem;
margin-bottom:.5rem
}
.mission-list li::before{
content:'';
position:absolute;
left:0;
top:.72em;
width:6px;
height:6px;
border-radius:50%;
background:rgba(11,43,92,.45)
}

/* CORE VALUES */
.values-grid{
display:grid;
grid-template-columns:1fr;
gap:10px
}
.value-pill{
background:#f8fafc;
border:1px solid #e2e8f0;
border-radius:8px;
padding:.85rem .9rem;
display:flex;
align-items:center;
gap:10px
}
.value-dot{
width:8px;
height:8px;
border-radius:50%;
flex-shrink:0
}
.dot-blue{background:#2563eb}
.dot-green{background:#16a34a}
.dot-purple{background:#9333ea}
.dot-amber{background:#d97706}
.value-text{
font-weight:600;
font-size:.9rem;
color:#334155
}

/* FOOTER */
.footer-custom{
flex-shrink:0;
background:#0b1f33;
color:#cddcec;
padding:1.25rem 1rem;
text-align:center;
font-size:.8rem
}

/* BACK TO TOP */
.top-link{
position:fixed;
right:20px;
bottom:20px;
width:42px;
height:42px;
border-radius:50%;
background:var(--navy);
color:#fff;
display:flex;
align-items:center;
justify-content:center;
box-shadow:0 6px 16px rgba(0,0,0,.25);
opacity:0;
pointer-events:none;
transition:opacity .25s ease,transform .25s ease;
transform:translateY(10px);
z-index:999
}
.top-link:hover{color:#fff}
.top-link.show{
opacity:1;
pointer-events:auto;
transform:translateY(0)
}

/* TABLET */
@media(max-width:950px){
.card-section{
grid-template-columns:repeat(2,minmax(0,1fr))
}
.mv-card:last-child{
grid-column:1 / -1
}
}

/* MOBILE */
@media(max-width:650px){
.content{
padding:0 .8rem 1.5rem
}
.card-section{
grid-template-columns:1fr;
gap:.9rem;
margin-top:1rem
}
.mv-card:last-child{
grid-column:auto
}
.card-header{
padding:.85rem 1rem
}
.card-body{
padding:.9rem 1rem 1.1rem;
font-size:.88rem;
line-height:1.6
}
.card-label{
font-size:1.05rem
}
.value-text{
font-size:.85rem
}
.values-grid{
grid-template-columns:1fr 1fr
}
}

@media(max-width:400px){
.btn-nav .btn-label{
display:none
}
.btn-nav{
padding:8px 11px
}
}
</style>
</head>

<body>
<?php include(VIEWS_PATH . '/partials/admin_loading_overlay.php'); ?>

<!-- NAVBAR -->
<nav class="navbar-custom">
<div class="navbar-inner">
<a class="navbar-brand" href="#">
<span>EPAMNHS</span>
</a>

<div class="nav-buttons">
<a href="login.php" class="btn-nav btn-login" data-loading-text="Taking you to login..." data-loading-icon="sign-in-alt">
<i class="fas fa-sign-in-alt"></i>
<span class="btn-label">Log in</span>
</a>

<a href="student_registration.php" class="btn-nav btn-register" data-loading-text="Loading registration form..." data-loading-icon="user-plus">
<i class="fas fa-user-plus"></i>
<span class="btn-label">Register</span>
</a>
</div>
</div>
</nav>

<!-- HERO -->
<header class="hero">
<img class="hero-bg" id="heroBg" src="icons/Documents/eusebia.jpg" alt="School campus">
<div class="hero-overlay"></div>

<div class="hero-content">
<p class="school-sub">Department of Education</p>

<div class="seal-ring">
<img src="icons/Documents/eusebia.png" alt="School Seal">
</div>

<h1 class="school-name">Eusebia Paz Arroyo Memorial National High School</h1>
<h6 class="address">Buluang, Baao, Camarines Sur</h6>

<div class="divider-gold"></div>
<p class="hero-caption">Mission · Vision · Core Values</p>
</div>
</header>

<!-- MAIN CONTENT -->
<main class="content">
<div class="card-section" data-aos="fade-up">

<!-- VISION -->
<article class="mv-card">
<div class="card-header">
<div>
<h2 class="card-label">Vision</h2>
</div>
</div>

<div class="card-body">
<p>We dream of Filipinos who passionately love their country and whose values and competencies enable them to realize their full potential and contribute meaningfully to building the nation.</p>

<p>As a learner-centered public institution, the Department of Education continuously improves itself to better serve its stakeholders.</p>
</div>
</article>

<!-- MISSION -->
<article class="mv-card" data-aos="fade-up" data-aos-delay="80">
<div class="card-header">
<div>
<h2 class="card-label">Mission</h2>
</div>
</div>

<div class="card-body">
<p>To protect and promote the right of every Filipino to quality, equitable, culture-based, and complete basic education where:</p>

<ul class="mission-list">
<li>Students learn in a child-friendly, gender-sensitive, safe, and motivating environment.</li>
<li>Teachers facilitate learning and constantly nurture every learner.</li>
<li>Administrators and staff ensure an enabling and supportive environment for effective learning.</li>
<li>Family, community, and stakeholders actively engage and share responsibility for developing life-long learners.</li>
</ul>
</div>
</article>

<!-- CORE VALUES -->
<article class="mv-card" data-aos="fade-up" data-aos-delay="160">
<div class="card-header">
<div>
<h2 class="card-label">Core Values</h2>
</div>
</div>

<div class="card-body">
<div class="values-grid">

<div class="value-pill">
<span class="value-dot dot-blue"></span>
<span class="value-text">Maka-Diyos</span>
</div>

<div class="value-pill">
<span class="value-dot dot-green"></span>
<span class="value-text">Maka-tao</span>
</div>

<div class="value-pill">
<span class="value-dot dot-purple"></span>
<span class="value-text">Makakalikasan</span>
</div>

<div class="value-pill">
<span class="value-dot dot-amber"></span>
<span class="value-text">Makabansa</span>
</div>

</div>
</div>
</article>

</div>
</main>

<!-- BACK TO TOP -->
<a href="#" class="top-link" id="backToTopBtn">
<i class="fas fa-arrow-up"></i>
</a>

<!-- FOOTER -->
<footer class="footer-custom">
<div class="container">
<i class="fas fa-school me-2"></i>
Eusebia Paz Arroyo Memorial National High School
<br>
<small><?= date('Y') ?> EPAMNHS.</small>
</div>
</footer>

<!-- SCRIPTS -->
<script src="js/pwa.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
AOS.init({
duration:800,
once:true,
offset:40
});

const backBtn=document.getElementById('backToTopBtn');

window.addEventListener('scroll',()=>{
backBtn.classList.toggle('show',window.scrollY>300);
});

backBtn.addEventListener('click',e=>{
e.preventDefault();
window.scrollTo({
top:0,
behavior:'smooth'
});
});

// LOADING OVERLAY on Log in / Register tap (same overlay used across the
// admin/login pages — see app/Views/partials/admin_loading_overlay.php)
document.querySelectorAll('.btn-login,.btn-register').forEach(function(btn){
btn.addEventListener('click',function(e){
e.preventDefault();
const destination=btn.getAttribute('href');
const message=btn.getAttribute('data-loading-text')||'Loading...';
const icon=btn.getAttribute('data-loading-icon')||'sync-alt';
showAdminLoading(message,icon);
window.location.href=destination;
});
});
</script>

</body>
</html>