<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<link rel="stylesheet" type="text/css" href="Component/Sidebar/sidebar-style.css">
<body>

    <div style="height:100vh; width:70px; z-index: 2;">
        <div id="side-container" style="position:absolute">
            <div class="side-bar">
                <div class="side-bar-title px-5 relative" style="height:50px">
                    <span class="side-bar-judul text-white text-2xl vertical-center hidden">CalonSultan</span>
                    <span class="vertical-center text-white right-0" style="transform:translateY(-40%);margin-right: 25px;" id="bar"><i class="fa-solid fa-bars text-xl"></i></span>
                </div>
                <div class="side-menu-container mt-4">
                    <div class="side-menu" target="0">
                    <i class="fa-solid fa-chart-line side-icon"></i>
                        <span class="side-span-text hidden">Dashboard</span>
                    </div>
                </div>
                <div class="side-menu-container">
                    <div class="side-menu" target="1">
                        <i class="fa-solid fa-wallet side-icon"></i>
                        <span class="side-span-text hidden">Keuangan</span>
                    </div>
                </div>
                <div class="side-menu-container">
                    <div class="side-menu" target="2">
                        <i class="fa-solid fa-print side-icon"></i>
                        <span class="side-span-text hidden">Laporan</span>
                    </div>
                </div>
                <div class="side-menu-container">
                    <div class="side-menu" target="3">
                        <i class="fa-solid fa-clock-rotate-left side-icon"></i>
                        <span class="side-span-text hidden">History</span>
                    </div>
                </div>
                <div class="side-menu-logout" style="width:100%">
                    <a href="landingpage.php">
                        <div class="side-menu-container">
                            <div class="side-menu" target="4">
                                <i class="fa-solid fa-arrow-left side-icon"></i>
                                <span class="side-span-text hidden">To Landingpage</span>
                            </div>
                        </div>
                    </a>
                    <a href="Controller/logout.php">
                        <div class="side-menu-container">
                            <div class="side-menu" target="4">
                                <i class="fa-solid fa-right-from-bracket side-icon"></i>
                                <span class="side-span-text hidden">Logout</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</body>

<script>
    //240 ke 87 
    let bar = $("#bar");
    let sidebar = $(".side-bar");

    $(document).click(function(e){
        let clickObj = $(e.target);
        let sbChildren = sidebar.children();

        if(clickObj.hasClass("side-bar") || clickObj.hasClass("side-menu") || clickObj.hasClass("side-menu-container") || clickObj.hasClass("side-bar-judul") || clickObj.hasClass("side-bar-title") || clickObj.hasClass("side-icon") || clickObj.hasClass("side-span-text") || clickObj.hasClass("fa-bars")){
        }else{
            if(!sidebar.hasClass("side-bar-active")){
                toggleSideBar();
            }
        }

    })

    toggleSideBar();

    function toggleSideBar(){
        let judul = $(".side-bar-judul");
        sidebar.toggleClass("side-bar-active");
        let menutext = $(".side-menu span");
        if(sidebar.hasClass("side-bar-active")){
            $.each(menutext, function (key, val) { 
                $(val).fadeOut(function(){
                    $(val).css({display:"none"});
                });
            });
            judul.fadeOut(function(){
                judul.css({display:"none"});
            });
        }else{
            $.each(menutext, function (key, val) { 
                $(val).fadeIn(function(){
                    $(val).css({display:"block"});
                });
            }); 
            judul.fadeIn(function(){
                judul.css({display:"block"});
            })
        }
    }

    bar.click(function() {
        toggleSideBar();
    });
</script>
</html>