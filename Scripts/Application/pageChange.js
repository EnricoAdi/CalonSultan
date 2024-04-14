var pages = [$("#dashboard"), $("#keuangan"), $("#laporan"), $("#history")];

let sideMenu = $(".side-menu");

$.each(sideMenu, function (k, v) { 
    let btn = $(v);
    btn.click(function(){
       let target = btn.attr("target"); 
       showPage(target);
    });
});;

function showPage(idxPage){
    idxPage = parseInt(idxPage);
    try{
        pages[idxPage].css({display:"block"});
        $.each(pages, function (i, v) { 
            if(i != idxPage){
                v.css({display:"none"});
            }
        });
    }catch(e){
        
    }
}