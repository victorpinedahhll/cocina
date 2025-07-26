<style>
html,body {
  height: 100%;
  font-family: 'Quicksand', sans-serif;
  scroll-behavior: smooth;
  background: #f4f6f9;
  color: #3e3e3e !important;
}
a {
  color: blue;
}
.color-uno {
  color: #069ef6 !important;
}
.color-dos {
  color: #002d59 !important;
}
.color-tres {
  color: #82909d !important;
}
.color-cuatro {
  color: #5b6d7e;
}
.text-success2 {
  color: #53f820;
}
.text-danger2 {
  color: #fe0a38;
}
.bg-uno {
  background: #069ef6 !important;
}
.bg-dos {
  background: #002d59 !important;
}
.bg-tres {
  background: #82909d !important;
}
.bg-cuatro {
  background: #5b6d7e;
}
input:disabled, select:disabled, textarea:disabled {
  background: #ffffff !important;
  border: 0px;
}
.container {
  height: 100%;
  align-content: center;
}
header {
  position: fixed;
  top: 0px;
  left: 0px;
  width: 100%;
  z-index: 99;
  background: #fff;
  height: 120px;
}
.navbar-nav .nav-link {
  color: #606060 !important;
  border-right: 1px solid #fff;
  border-bottom: 1px solid #f4f4f4;
  font-size: 10pt;
}
.navbar-nav .nav-link.active, .navbar-nav .nav-link:hover {
  color: #ffffff !important;
  background: #002d59;
  border-bottom: 1px solid #C0C0C0;
  font-size: 10pt;
  /* text-shadow: 0px 1px 1px #3e3e3e; */
}
.navbar-nav .nav-link.active {
  font-weight: bold !important;
}
.logo-home {
  padding: 10px 0px 30px 0;
  margin: 0px;
}
.card {
  height: 370px;
  margin-top: auto;
  margin-bottom: auto;
  width: 400px;
  background-color: rgba(255,255,255,0.5) !important;
}
.card-header {
  color: #fff;
  background: #069ef6;
  padding-top: 20px;
}
.submit {
  background: #069ef6 !important;
  color: #fff !important;
  font-weight: bold !important;
  border: 0px !important;
}
.btn-muted {
  background: #eee;
  color: #808080;
  font-weight: bold;
  border: 0px;
}
.input-group-prepend span {
  width: 45px;
  background-color: #002d59;
  color: white;
  border:0 !important;
}
input:focus {
  outline: 0 0 0 0  !important;
  box-shadow: 0 0 0 0 !important;
}
.remember {
  color: #002d59;
}
.remember input {
  width: 20px;
  height: 20px;
  margin-left: 15px;
  margin-right: 5px;
}
.login_btn {
  color: #fff;
  background-color: #069ef6;
  width: 100px;
}
.login_btn:hover {
  color: #fff;
  background-color: #9b1419;
}
.links {
  color: white;
}
.links a {
  margin-left: 4px;
}
.card-footer a {
  color: #808080;
}
@media (min-width: 768px){
  .dashboard {
    padding-top: 150px;
  }
}
.filtro-cal {
  background: #fff;
  padding: 10px 20px 12px 20px;
  border-radius: 7px;
  border:  1px solid #dad8d8;
}
@media (max-width: 991px){
  .filtro-cal {
    padding: 0 20px;
  }
  .filtro-cal select, .filtro-cal input {
    margin-bottom: 7px;
  }
  .col-100-top {
    width: 100%;
  }
}
/* ADMIN */
.sidebar {
  position: fixed;
  top: 0px;
  left: 0px;
  background: #63a6bf url('images/fondo-sidebar2.jpg') no-repeat top left;
  background-size: cover;
  min-height: 100%;
  width: 250px;
  padding-top: 22px;
  border-right: 1px solid #C0C0C0;
  z-index: 30;
}
.h4-sidebar {
  background: #069ef6;
  color: #002d59;
  height: 35px;
  line-height: 35px;
  font-size: 12pt;
  margin-top: 15px;
  border-radius: 4px;
  font-weight: bold;
}
.h4-sidebar-nobg {
  background: #002d59;
  color: #fff;
  height: 35px;
  line-height: 35px;
  font-size: 12pt;
  margin-top: 15px;
  border-radius: 4px;
  font-weight: bold;
  padding-left: 12px;
}
.sidebar ul {
  list-style-type: none;
  padding-left: 5px;
}
.sidebar ul > li {
  border-bottom: 1px dotted #002d59;
}
.sidebar ul > li > a {
  display: block;
  color: #002d59;
  padding: 5px 0 5px 5px !important;
}
.sidebar i {
  padding-right: 5px;
  font-size: 14pt;
}
.content-box {
  height: 100%;
  padding: 10px 20px 50px 20px;
}
@media (max-width: 767px){
  .content-box {
    padding: 50px 30px;
  }
}
.content-box .sort {
  position: absolute;
  top: 20px;
  right: 30px;
}
.content-box .sort a {
  color: #82909d;
  font-size: 18pt;
  margin-left: 12px;
}
.header-top-box {
  position: fixed;
  top:0px;
  right: 0px;
  width: 100%;
  background: #fff;
  color: #82909d;
  height: 60px;
  line-height: 55px;
  border-bottom: 1px solid #C0C0C0;
  padding-right: 25px;
  font-size: 10pt;
  z-index: 20;
}
@media (max-width: 767px){
  .header-top-box {
    left: 0px;
    padding-right: 15px;
    padding-left: 25px;
    margin-right: 0px;
    background: #8acce2;
    
  }
  .header-top-box .btn {
    box-shadow: none;
  }
}
.header-top-box a {
  color: #5eb3d0;
}
.calendar-top-toogle {
  width: 350px;
  z-index: 100;
}
.content-text {
  border: 1px solid #d9d6d6;
  background: #fff;
  padding: 22px;
  box-shadow: 2px 2px 4px #d9d6d6;
  border-radius: 4px;
  min-height: 350px;
  z-index: 5;
  overflow: hidden;
  margin: 160px 21px 0 21px;
}
.content-box h1, .content-box-calendar h1 {
  font-size: 20pt;
  color: #5b6d7e;
  margin-top: 0px;
  letter-spacing: -1.5px;
  margin-bottom: 25px;
  text-shadow: 0px 1px 1px #FFF !important;
  padding-left: 15px;
}
.content-text h3 {
  color: #82909d;
  font-weight: 500;
  letter-spacing: -.5px;
  font-size: 20pt;
  margin-bottom: 30px;
}
.content-text h3, .content-text h3 a, .content-text h5 {
  color: #82909d;
}
.calendar-fixed, .menu-fixed {
  position: absolute;
  top:10px;
  right: 10px;
  width: 320px;
  height: 100%;
  z-index: 10;
}
.table-agenda {
  width: 100%;
  margin: 0 auto;
  border-top: 1px solid #e1e1e1;
  border-left: 1px solid #e1e1e1;
}
.table-agenda th {
  position: relative;
  text-align: center;
  height: 40px;
  line-height: 40px;
  border-right: 1px solid #e1e1e1; 
  border-bottom: 1px solid #e1e1e1;
  font-size: 10pt;
  background: #1a3a6c;
  color: #fff;
}
.table-agenda td {
  position: relative;
  text-align: center;
  height: 40px;
  border-right: 1px solid #e1e1e1; 
  border-bottom: 1px solid #e1e1e1;
  font-size: 10pt;
}
.table-agenda .td-cal a {
  display: block;
  height: 40px;
  line-height: 40px;
}
.table-agenda .td-cal, .table-agenda .td-cal a:hover {
  text-decoration: none !important;
  background: #f0f9fd;
}


.operac-reg, .operac-reg-titulos {
  border-bottom: 1px dotted #C0C0C0;
  padding: 20px 12px 12px 12px;
  font-size: 11pt;
}
.operac-reg p, .operac-reg-titulos p {
  margin-bottom: 0px;
}
.operac-reg h4, .operac-reg-block h4, .operac-reg-titulos h4, .operac-reg-block-titulos h4 {
  font-weight: bold;
  color: #4688cc;
  font-size: 12pt;
}
.operac-reg-block {
  float: left;
  width: 32%;
  border: 1px solid #d9d6d6;
  margin: 0px 1.3% 20px 0px !important;
  padding: 20px 0 20px 20px;
  height: 470px;
  box-shadow: 2px 2px 4px #d9d6d6;
}
.operac-reg-block-titulos {
  float: left;
  width: 32%;
  border: 1px solid #d9d6d6;
  margin: 0px 1.3% 20px 0px !important;
  padding: 20px 0 20px 20px;
  height: 570px;
  box-shadow: 2px 2px 4px #d9d6d6;
}
.operac-reg-block p, .operac-reg-block-titulos p {
  margin: 0px;
}
.bg-muted {
  background: #f4f4f4;
}
.form-active h5 {
  color: #002d59;
}
.vad-familia ul {
  list-style-type: none;
  padding-left: 0px;
  margin-left: 0px;
}
.vad-familia li {
  border-bottom: 1px solid #1d708c;
}
.vad-familia li a {
  display: block;
  color: #fff;
  padding: 9px 15px;
  font-size: 10pt;
}
.vad-familia li a:hover {
  background: #1d708c;
  text-decoration: none;
}
.marco-vad {
  border: 1px solid #C0C0C0;
  padding: 15px;
  margin: 12px;
  height: 250px;
  background: #fff;
}
.marco-vad h5 {
  margin: 0 0 12px 0 !important;
  font-size: 15px;
}
.marco-vad p {
  margin: 0px !important;
}
.marco-vad p {
  font-size: 10pt;
  color: #1d708c;
}
.edit {
  position: absolute;
  top: 12px;
  right: 12px;
  z-index: 9999;
}
.btn-text {
  display: block;
  color: #333 !important;
  border: 1px solid #808080;
  width: 100%;
  text-align: center;
  border-radius: 4px;
  box-shadow: 2px 3px 3px #e6e3e3;
}
.btn-text:hover {
  text-decoration: none !important;
  box-shadow: 2px 3px 3px #cbc9c9;
  font-weight: bold;
}
.areas-accesos {
  list-style-type: none;
  padding-left: 0px;
  margin-left: 0px;
  margin-top: 25px;
}
.areas-accesos li {
  padding-bottom: 7px;
  font-size: 13pt;
}
.bg-cuatro {
    background: #17a2b8;
}
.sidebar ul > li > a:hover {
    background: rgba(22,122,192,0.2);
    text-decoration: none;
}
.status-active b {
    background: green;
    color: #fff;
    border-radius: 30px;
    padding: 5px 10px;
}
.status-inactive b {
    background: red;
    color: #fff;
    padding: 5px 10px;
    border-radius: 30px;
}
.form-ul {
  list-style-type: none;
  overflow: hidden;
  width: 100%;
  padding-left: 0px;
  padding-bottom: 12px;
}
.form-ul li {
  float: left;
}
.movil-menu {
    display: none;
}
.movil-menu a {
  color: #3e3e3e;
}
@media (max-width: 1100px){
    .sidebar {
        width: 200px !important;
    }
}
@media (max-width: 767px){
    .movil-menu {
        display: block;
        position: absolute;
        top: 0px;
        right: 13px;
        font-size: 20pt;
    }
    .header-top-box span {
        display: none;
    }
    .content-box h1 {
        font-size: 16pt;
    }
    .operac-reg-block, .operac-reg-block-titulos {
        float: none !important; 
        width: 100% !important;
        height: auto;
        padding: 20px 10px 20px 20px;
    }
    .operac-reg, .operac-reg-titulos {
        border: 1px solid #d9d6d6;
        margin: 0px 1.3% 20px 0px !important;
        padding: 20px 0 20px 7px;
        height: auto;
        box-shadow: 2px 2px 4px #d9d6d6;
    }
    .operac-reg-block h4, .operac-reg h4, .operac-reg-titulos h4, .operac-reg-block-titulos h4 {
        margin-top: 10px;
    }
    .content-text .sort {
        display: none !important;
    }
    .content-text h3 {
        font-size: 14pt;
    }
    .menu-fixed {
      position: absolute;
      top:10px;
      right: 10px;
      width: 320px;
      height: auto !important;
      z-index: 10;
    }
    .menu-fixed ul {
      list-style-type: none;
      padding-left: 5px;
    }
    .menu-fixed ul > li {
      border-bottom: 1px dotted #002d59;
    }
    .menu-fixed ul > li > a {
      display: block;
      color: #002d59;
      padding: 5px 0 5px 5px !important;
    }
    .menu-fixed i {
      padding-right: 5px;
      font-size: 14pt;
    }
}
.col-desktop-2 {
    position:relative;
    width:100%;
    padding-right:15px;
    padding-left:15px
    -ms-flex:0 0 83.333333%;
    flex:0 0 83.333333%;
    max-width:83.333333%
}
@media (max-width: 991px){
    .sidebar, .col-desktop {
        display: none !important;
    }
    .col-desktop-2 {
        width: 100% !important;
        float: none;
    }
}
@media (max-width: 991px){
  .esconder-desktop {
    display: block;
  }
  .esconder-movil {
    display: none !important;
  }
}
@media (min-width: 992px){
  .esconder-desktop {
    display: none !important;
  }
  .esconder-movil {
    display: block;
  }
}
@media (max-width: 1024px){
  .esconder-tablet {
    display: none;
  }
}
.pagination-2 {
    width: 100%;
    margin: 35px auto 20px auto;
    text-align: center !important;
    overflow: hidden;
}
.pagination-2 a {
    margin-right: 3px;
    background: #fff;
    /* border: 1px solid #808080; */
    border-radius: 4px !important;
    padding: 30px 20px !important;
    height: 45px;
    line-height: 45px;
    text-align: center;
    color: #808080 !important;
}
.pagination-2 a:hover {
    background: #e5f5f7;
    text-decoration: none;
}
@media (max-width: 767px){
    .pagination-2 a {
        padding: 5px 10px !important;
        height: 33px;
        line-height: 33px;
        margin-bottom: 25px !important;
    }
}
.pag-active {
    background: #cde3f7 !important;
    color: #fff !important;
    font-weight: bold;
}
.scroll-to-top {
  display: none;
}
@media(max-width: 767px){
  .dash-noti {
    margin-top: 50px;
  }
}
.overflowbox {
  height: 500px;
  overflow: auto;
  padding-left: 1px;
  padding-right: 1px;
}
.pruebas-box p {
  font-size: 10pt;
}
.pruebas-box b {
  font-size: 10pt;
}
.text-center-left {
  text-align: center;
}
.text-right-center {
  text-align: right;
}
.text-left-center {
  text-align: left;
}
.text-right-left {
  text-align: right;
}
.text-left-right {
  text-align: left;
}
.box-form {
  /*margin-top: -72px;*/
  margin-top: -57px;
}
.box-form h5 {
  background: #069ef6;
  color: #fff;
  text-align: center;
  padding: 12px;
  width: 100%;
  position: absolute;
  top: -10px;
  left: 0px;
}
.box-form h5 b {
  font-size: 18pt;
}
.opc-hora {
  display: block;
  border: 1px solid #C0C0C0;
  border-radius: 4px;
  margin: 0px 2px;
  width: 100%;
  padding: 6px 0px;
}
.opc-hora:hover {
  text-decoration: none;
  background: #f0f9fd;
}
.opc-active {
  background: #17a2b8 !important;
  color:  #fff;
  font-weight: bold;
}
@media (max-width: 991px){
  .text-center-left {
    text-align: left;
  }
  .text-right-center, .text-left-center {
    text-align: center;
  }
  .text-right-left {
    text-align: left;
  }
  .text-left-right {
    text-align: right;
  }
  .box-lab-hora {
    margin-top: 20px;
  }
  .box-form {
    margin-top: -20px;
  }
  .box-form h5 b {
    font-size: 16pt;
  }
  .box-form h5 {
    font-size: 16pt;
  }
}
.tit-menu div, .pruebas-box div {
  padding-left: 4px !important;
  padding-right: 4px !important; 
}
.modal {
  z-index: 9999999 !important;
}


.container {
  margin-top: 20px;
}
.logo-mspas {
  height: 75px;
}
.logo-dde {
  height: 60px;
}
label {
  font-weight: bold;
}
h5 {
  color: #538cbe;
  font-weight: 500;
  margin-top: 10px;
  margin-bottom: 25px;
}
@media (min-width: 992px){
  .form-group {
    padding-left: 15px !important;
    padding-right: 15px !important;
  }
}
.bg-mb {
  margin-top: 10px;
  margin-bottom: 7px;
}
.marco {
  box-shadow: 1px 10px 10px #808080;
  background: #fff;
  padding: 25px 30px;
  margin-top: 20px;
  margin-bottom: 10px;
  border-radius: 7px;
  border: 1px solid #c9d0da;
}

.grupo-qty {
  padding-right: 10px;
}
@media (max-width: 991px){
  .grupo-qty {
    padding-right: 0px;
  }
}
.container-cart {
  width: 1110px;
  margin:  0 auto;
}
@media (max-width: 1200px){
  .container-cart {
    width: 95% !important;
  }
}
.logout .active {
  font-weight: bold;
  font-size: 11pt;
}
.logout {
  color: #3e3e3e !important;
  background-color: #f4f4f4;
  width: 100%;
  position: fixed;
  top: 0px;
  left: 0px;
  z-index: 77777;
}
.logout a {
  color: blue !important;
}
.title-formpay {
  color: #000;
  background: #f3f3f3;
  margin-bottom: 20px;
}
.title-formpay h4 {
  color: #7d7c7c;
  text-shadow: 0px 1px 1px #fff;
}
.box-admin-opt {
  background: #fff;
  padding: 30px;
  border-radius: 4px;
  box-shadow: 5px 10px 10px -10px #808080;
}
.box-admin-opt-art {
  background: #fff url('images/bg-paper2.jpg') no-repeat;
  padding: 30px;
  border-radius: 4px;
  box-shadow: 0px 10px 15px #000;
}

.box-menu {
  background: #e6e6e6;
  font-size: 11pt;
  color: #3e3e3e;
  padding: 7px 0px !important;
  border-radius: 4px;
  text-shadow: 0px 1px 1px #fff;
  border-right: 1px solid #d0d0d0;
  border-bottom: 1px solid #d0d0d0;
  /* box-shadow: 5px 10px 10px -10px #C0C0C0; */
}

.box-items {
  background: #fff;
  border-radius: 4px;
  padding: 12px !important;
  box-shadow: 5px 10px 10px -10px #C0C0C0;
  margin-bottom: 7px;
  font-size: 11pt;
}

.title-menu {
  font-family: 'Sansita Swashed';
  font-size: 22pt;
  text-shadow: 0px 1px 1px #000;
  background: linear-gradient(#271512,#070400);
  color: #fff;
  padding: 32px 0;
  text-align: center;
  margin: -30px -30px 30px -30px;
  /*border-bottom: 7px solid #e5a917;*/
}

.table-elegidas {
  width: 100%;
}
.table-elegidas .row {
  border-bottom: 1px solid #c0c0c0;
  font-size: 12pt;
  line-height: 15pt;
  padding-top: 2px;
  padding-right: 12px;
  padding-bottom: 12px !important;
}
@media (max-width: 1500px){
  .table-elegidas .row {
    padding-top: 5px;
    padding-right: 0px;
    padding-bottom: 12px;
  }
  .table-elegidas .row div {
    padding-right: 0px;
    padding-left: 0px;
  }
}

.blink_me {
  animation: blink-custom 3s infinite ease-in-out;
  opacity: 1;
}

@keyframes blink-custom {
  0%   { opacity: 1; }   /* visible */
  70%  { opacity: 1; }   /* sigue visible */
  75%  { opacity: 0; }   /* desaparece rápido */
  80%  { opacity: 1; }   /* vuelve a aparecer rápido */
  100% { opacity: 1; }   /* permanece visible */
}
</style>