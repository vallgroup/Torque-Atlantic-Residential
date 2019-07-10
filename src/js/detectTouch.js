jQuery(document).ready(function($) {
  window.addEventListener(
    "touchstart",
    function onFirstTouch() {
      // we could use a class
      document.body.classList.add("touch-screen-detected");

      // we only need to know once that a human touched the screen, so we can stop listening now
      window.removeEventListener("touchstart", onFirstTouch, false);
    },
    false
  );
});
