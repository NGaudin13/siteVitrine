document.addEventListener("DOMContentLoaded", () => {
  const el = document.querySelector(".services-swiper");
  if (!el) return;

  // Swiper structure & CDN as in CodingNepal tutorial, adapted to your section. :contentReference[oaicite:3]{index=3}
  new Swiper(".services-swiper", {
    loop: false,              // avec 4 services visibles en desktop, loop peut être inutile
    grabCursor: true,
    spaceBetween: 18,
    centeredSlides: false,

    pagination: {
      el: ".services-swiper__pagination",
      clickable: true,
    },

    navigation: {
      nextEl: ".services-swiper__btn--next",
      prevEl: ".services-swiper__btn--prev",
    },

    // 4 visibles sur écran large (ta demande)
    breakpoints: {
      0:    { slidesPerView: 1.1 },
      576:  { slidesPerView: 2.1 },
      992:  { slidesPerView: 3.1 },
      1200: { slidesPerView: 4 },
    },
  });
});
