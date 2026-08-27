<!DOCTYPE html>
<html lang="en">
<head>
<title>EPAMNHS | Vision, Mission & Core Values</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="manifest" href="manifest.php">
<link rel="icon" type="image/png" sizes="32x32" href="icons/pwa/icon-96x96.png">
<meta name="theme-color" content="#0b2b5c">

<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{
font-family:'Inter',sans-serif;
background:linear-gradient(145deg,#f8faff 0%,#f0f4fe 100%);
color:#1a2c3e;
min-height:100vh
}

/* NAVBAR */
.navbar-custom{
background:linear-gradient(135deg,#0b2b5c 0%,#0f3b7a 100%);
padding:0;
box-shadow:0 4px 20px rgba(0,0,0,.12);
position:sticky;
top:0;
z-index:1000
}
.navbar-inner{
display:flex;
align-items:center;
justify-content:space-between;
padding:.85rem 1.5rem;
gap:.75rem
}
.navbar-brand{
font-family:'Playfair Display',serif;
font-weight:700;
font-size:clamp(1rem,3.5vw,1.4rem);
color:white!important;
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
gap:10px;
flex-shrink:0
}
.btn-nav{
border-radius:40px;
padding:7px 18px;
font-weight:500;
font-size:.875rem;
transition:all .2s;
text-decoration:none;
display:inline-flex;
align-items:center;
gap:7px;
white-space:nowrap
}
.btn-login{
background:rgba(255,255,255,.12);
border:1px solid rgba(255,255,255,.28);
color:white
}
.btn-login:hover{
background:rgba(255,255,255,.25);
color:white
}
.btn-register{
background:rgba(255,215,0,.8);
border:1px solid #ffd700;
color:#0b2b5c;
font-weight:600
}
.btn-register:hover{
background:#ffd700;
transform:translateY(-2px);
color:#0b2b5c
}

/* HERO */
.hero{
position:relative;
width:100%;
min-height:360px;
padding:2rem 0 2.75rem;
overflow:hidden;
display:flex;
align-items:center;
justify-content:center;
text-align:center
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
font-size:.85rem;
letter-spacing:1px;
margin:0 0 .5rem
}
.seal-ring{
width:100px;
height:100px;
margin:0 auto .7rem;
background:rgba(255,255,255,.12);
border:1px solid rgba(255,255,255,.2);
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
box-shadow:0 8px 25px rgba(0,0,0,.18)
}
.seal-ring img{
width:78px;
height:78px;
object-fit:contain;
filter:brightness(1.05) contrast(1.1);
background:rgba(255,255,255,.92);
border-radius:50%;
padding:6px
}
.school-name{
font-family:'Playfair Display',serif;
font-size:clamp(1.3rem,4.5vw,2.1rem);
font-weight:700;
color:white;
text-shadow:0 2px 8px rgba(0,0,0,.3);
max-width:700px;
margin:0 auto
}
.address{
font-family:'Playfair Display',serif;
color:white;
text-shadow:0 2px 8px rgba(0,0,0,.3);
margin:0 auto
}
.divider-gold{
width:70px;
height:2px;
background:linear-gradient(90deg,transparent,#ffd700,transparent);
margin:.6rem auto
}
.hero-caption{
color:rgba(255,255,255,.75);
font-size:.82rem;
letter-spacing:.5px
}

/* MAIN CONTENT */
.content{
width:100%;
max-width:1600px;
margin:0 auto;
padding:0 2rem 2rem
}

/* HORIZONTAL CARDS */
.card-section{
display:grid;
grid-template-columns:repeat(3,minmax(0,1fr));
gap:2rem;
margin-top:1rem;
position:relative;
z-index:5
}

/* CARDS */
.mv-card{
background:rgba(255,255,255,.98);
border-radius:18px;
box-shadow:0 10px 25px -8px rgba(0,0,0,.12);
overflow:hidden;
display:flex;
flex-direction:column;
height:100%;
transition:transform .25s ease,box-shadow .25s ease
}
.mv-card:hover{
transform:translateY(-5px);
box-shadow:0 18px 30px -10px rgba(0,0,0,.16)
}

/* CARD HEADER */
.card-header{
padding:1.2rem 1.4rem .85rem;
display:flex;
align-items:center;
gap:.7rem;
border-bottom:1px solid #eef2f8
}

/* CARD TITLE */
.card-label{
font-size:1.4rem;
font-weight:700;
font-family:'Playfair Display',serif;
color:#0b2b5c;
line-height:1.15;
margin:0
}
.card-tagline{
font-size:.7rem;
text-transform:uppercase;
letter-spacing:1px;
color:#69788a;
margin-top:.2rem;
margin-bottom:0
}

/* CARD BODY */
.card-body{
padding:1.15rem 1.4rem 1.4rem;
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
padding-left:1.25rem;
margin-bottom:.5rem
}
.mission-list li::before{
content:"✓";
position:absolute;
left:0;
top:1px;
width:18px;
height:18px;
border-radius:50%;
background:#e4f5e9;
color:#27834a;
display:flex;
align-items:center;
justify-content:center;
font-size:.65rem;
font-weight:700
}

/* CORE VALUES */
.values-grid{
display:grid;
grid-template-columns:repeat(2,1fr);
gap:12px;
margin-top:.6rem
}
.value-pill{
background:#f8fafc;
border-radius:10px;
padding:1rem .9rem;
display:flex;
align-items:center;
gap:9px;
border:1px solid #e2e8f0
}
.value-dot{
width:10px;
height:10px;
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
background:#0b1f33;
color:#cddcec;
padding:1.2rem 1rem;
text-align:center;
font-size:.8rem;
border-top-left-radius:22px;
border-top-right-radius:22px
}

/* BACK TO TOP */
.top-link{
position:fixed;
right:20px;
bottom:20px;
width:44px;
height:44px;
border-radius:50%;
background:#0b2b5c;
color:white;
display:flex;
align-items:center;
justify-content:center;
box-shadow:0 6px 16px rgba(0,0,0,.25);
opacity:0;
pointer-events:none;
transition:opacity .25s ease, transform .25s ease;
transform:translateY(10px);
z-index:999
}
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
margin-top:.8rem
}
.mv-card:last-child{
grid-column:auto
}
.card-header{
padding:.9rem 1rem .65rem
}
.card-body{
padding:.9rem 1rem 1.1rem;
font-size:.85rem;
line-height:1.6
}
.card-label{
font-size:1.15rem
}
.card-tagline{
font-size:.62rem
}
.value-text{
font-size:.8rem
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
padding:8px 11px;
border-radius:50%
}
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar-custom">
<div class="navbar-inner">
<a class="navbar-brand" href="#">
<i class="bi bi-mortarboard-fill" style="flex-shrink:0;"></i>
<span>EPAMNHS Portal</span>
</a>

<div class="nav-buttons">
<a href="login.php" class="btn-nav btn-login">
<i class="fas fa-sign-in-alt"></i>
<span class="btn-label">Log in</span>
</a>

<a href="student_registration.php" class="btn-nav btn-register">
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
<p class="card-tagline">Our Aspiration</p>
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
<p class="card-tagline">Our Purpose</p>
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
<p class="card-tagline">What We Stand For</p>
</div>
</div>

<div class="card-body">
<p>These values guide every learner, teacher, and staff member of EPAMNHS in living out the DepEd mandate:</p>
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
</script>

</body>
</html>