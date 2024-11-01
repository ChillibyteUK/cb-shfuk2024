/**
 * postcode form redirect
 **/

// function redirectToFormAll() {

//     var pcode = document.getElementById("pcode").value;
//     var addr1 = document.getElementById("addr1").value;
//     var addr2 = document.getElementById("addr2").value;
//     var town = document.getElementById("town").value;
//     var county = document.getElementById("county").value;

//     var url = "/free-cash-offer?postcode=" + encodeURIComponent(pcode) +
//               "&addr1=" + encodeURIComponent(addr1) +
//               "&addr2=" + encodeURIComponent(addr2) +
//               "&town=" + encodeURIComponent(town) +
//               "&county=" + encodeURIComponent(county);

//     window.location.href = url;

// }

// window.redirectToFormAll = redirectToFormAll; // Make sure it's accessible globally


// function redirectToForm() {
//     var postcodes = document.getElementsByClassName("postcode");
//     var postcodeValue = "";

//     for (var i = 0; i < postcodes.length; i++) {
//         if (postcodes[i].value.trim() !== "") {
//             postcodeValue = postcodes[i].value.trim();
//             break; // Exit the loop once the first filled input is found
//         }
//     }

//     if (postcodeValue) {


//         var addr1 = document.getElementById("haddr1").value;
//         var addr2 = document.getElementById("haddr2").value;
//         var town = document.getElementById("htown").value;
//         var county = document.getElementById("hcounty").value;
//         console.log(addr1 + ' ' + addr2 + ' ' + town + ' ' + county);

//         var url = "/free-cash-offer?postcode=" + encodeURIComponent(postcodeValue);
//         // window.location.href = url;
//     }

// }

// window.redirectToForm = redirectToForm; // Make sure it's accessible globally


/**
 * hide navigation
 **/

document.addEventListener('DOMContentLoaded', function() {
    var mainNav = document.querySelector('header');
    var lastScrollTop = 0;

    window.addEventListener('scroll', function() {
        var scrollTop = window.scrollY || document.documentElement.scrollTop;
        
        // Prevent negative scrollTop (elastic scroll) from causing the nav to hide
        if (scrollTop < 0) {
            scrollTop = 0;
        }

        if (scrollTop > lastScrollTop) {
            // Scrolling down
            mainNav.classList.add('hidden');
        } else {
            // Scrolling up
            mainNav.classList.remove('hidden');
        }

        lastScrollTop = scrollTop;
    });

});
