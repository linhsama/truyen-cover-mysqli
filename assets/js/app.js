// Khởi tạo các biến
var navbar = document.querySelector(".navbar"),
    navbarMenu = document.querySelector(".navbar-menu"),
    navbarToggle = document.querySelector(".navbar-toggle"),
    navbarClose = document.querySelector(".navbar-close"),
    navbarAvatar = document.querySelector(".navbar-avatar"),
    userAction = document.querySelector(".navbar-user-action"),
    floatingAction = document.querySelector(".floating-action"),
    actionToggle = document.querySelector(".action-toggle"),
    actionHome = document.querySelector(".action-home"),
    actionMenu = document.querySelector(".action-menu"),
    actionTop = document.querySelector(".action-top"),
    actionUser = document.querySelector(".action-user"),
    searchInput = document.querySelector("#search-box"),
    searchIcon = document.querySelector(".navbar-search .icon");
//actionAuto = document.querySelector(".action-down");
//actionAutoStop = document.querySelector("action-stop");
mangaAction = document.querySelector(".manga-action");

// Hàm cuộn trang
function scrollTo(t, e, n) {
    if (!(n <= 0)) {
        var o = (e - t.scrollTop) / n * 10;
        setTimeout(function() {
            t.scrollTop = t.scrollTop + o, t.scrollTop != e && scrollTo(t, e, n - 10)
        }, 10)
    }
}

// Hàm cuộn trang
function scrollPageTo(t, e) {
    try {
        return void(document.body.scrollTop > 0 ? scrollTo(document.body, t, e) : scrollTo(document.documentElement, t, e))
    } catch (t) {}
    window.scrollTo(0, t)
}


function scrollPageAuto() {

    let scrollerID;
    let interval = 50;

    setInterval(function() {
        window.scrollBy(0, 500);
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            clearInterval(scrollerID);
        }
    }, interval);
}



// Hàm tìm kiếm
function search() {
    searchInput.value.length && (window.location.href = "index.php?tim-kiem=" + slugify(searchInput.value))
}

// Tao url thân thiện slugify
function slugify(t) {
    slug = t.toString().toLowerCase();
    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //Xóa các ký tự đặt biệt
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, " - ");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    return slug;
}

// Ẩn hiện nút floatingAction nếu chiều cao khung hình khi cuộn > 5
function hideFloatingAction() {
    window.pageYOffset > 5 ? floatingAction.classList.remove("hidden") : floatingAction.classList.add("hidden")
}



// Bắt sự kiện nhấn enter và icon search
searchInput.onkeydown = function(t) {
    13 == t.which && search()
}, searchIcon.onclick = function() {
    search()
};


// Ẩn hiện activeUserAction 
function activeUserAction() {
    navbar.classList.remove("active-menu"), // xóa class active-menu
        navbar.classList.add("active-user-menu"), // thêm class active-user-menu
        floatingAction.classList.remove("activated"), // Xóa class activated của nút floatingAction
        actionToggle.innerHTML = '<i class="fas fa-crosshairs"></i>' // gán icon cho nút actionToggle
}

// Ẩn hiện activeMenu
function activeMenu() {
    navbar.classList.add("active-menu"), //thêm class active-menu
        navbar.classList.remove("active-user-menu"), // xóa class active-user-menu
        floatingAction.classList.remove("activated"), // Xóa class activated của nút floatingAction
        actionToggle.innerHTML = '<i class="fas fa-crosshairs"></i>' // gán icon cho nút actionToggle
}
// Bắt các sự kiện on click
navbarAvatar.onclick = function() {
    activeUserAction(),
        userAction.classList.toggle("hidden")
}
actionUser.onclick = function() {
    activeUserAction(), userAction.classList.remove("hidden")
}


navbarClose.onclick = function() {
    navbar.classList.remove("active-menu")
}

navbarToggle.onclick = function() {
    navbar.classList.add("active-menu")
}

actionToggle.onclick = function() {
    floatingAction.classList.contains("activated") ? (floatingAction.classList.remove("activated"),
        this.innerHTML = '<i class="fas fa-crosshairs"></i>') : (floatingAction.classList.add("activated"),
        this.innerHTML = '<i class="fas fa-times"></i>')
}

actionHome.onclick = function() {
    window.location.href = './index.php'
}

actionMenu.onclick = function() {
    activeMenu()
}


actionTop.onclick = function() {
    scrollPageTo(0, 600)
}

// actionAuto.onclick = function () {
//     scrollPageAuto()
// }
// actionAutoStop.onclick = function () {
//     location.reload();
//}

// Lắng nghe sự kiện scroll
window.addEventListener("scroll", hideFloatingAction), window.addEventListener("click", function(t) {
        navbarAvatar.contains(t.target) ||
            userAction.contains(t.target) ||
            actionUser.contains(t.target) ||
            (userAction.classList.add("hidden"),
                navbar.classList.remove("active-user-menu"))
    }),

    // Lắng nghe sự kiện click
    window.addEventListener("click", function(t) {
        navbarToggle.contains(t.target) ||
            navbarMenu.contains(t.target) ||
            actionMenu.contains(t.target) ||
            navbar.classList.remove("active-menu")
    });