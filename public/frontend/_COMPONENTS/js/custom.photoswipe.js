// var gallery = {};
// var openPhotoSwipe = function(goTo) {
//     var pswpElement = document.querySelectorAll('.pswp')[0];
//     // build items array
//     var items = [
//         {
//             src: 'assets/img/hero/1.jpg',
//             w: 1600,
//             h: 900
//         },
//         {
//             src: 'assets/img/hero/2.jpg',
//             w: 1600,
//             h: 900
//         }
//     ];
    
//     // define options (if needed)
//     var options = {
//         // history & focus options are disabled on CodePen
//         history: false,
//         focus: false,
//         index: goTo,
//         maxSpreadZoom: 1,
//         getDoubleTapZoom: function (isMouseClick, item) {
//             return item.initialZoomLevel;
//         },

//         showAnimationDuration: 0,
//         hideAnimationDuration: 0,

//         bgOpacity: 0.9,
//         fullscreenEl:  false,
//         zoomEl:  false,
//         shareEl:  false,

//         closeOnScroll: false
//     };
    
//     gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
//     gallery.init();
// };

// $('body').on('click', '.opet', function(e){
//     e.preventDefault();

//     var id = 3;
//     openPhotoSwipe(id);

//     gallery.items.push(
//         {
//             src: 'assets/img/hero/3.jpg',
//             w: 1600,
//             h: 900
//             //title: "asdasdasd",
//         },
//         {
//             src: 'assets/img/hero/4.jpg',
//             w: 1600,
//             h: 900
//             //title: "asdasdasd"
//         },
//         {
//             src: 'assets/img/hero/5.jpg',
//             w: 1600,
//             h: 900
//             //title: "asdasdasd"
//         }
//     );
// });