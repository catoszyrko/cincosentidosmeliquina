(() => {
  const header = document.querySelector("[data-header]");
  const onScroll = () => header?.classList.toggle("is-scrolled", window.scrollY > 12);
  onScroll();
  window.addEventListener("scroll", onScroll, { passive: true });

  const toggle = document.querySelector("[data-nav-toggle]");
  const closeBtn = document.querySelector("[data-nav-close]");
  const panel = document.querySelector("[data-nav-panel]");
  const setOpen = (open) => {
    panel?.classList.toggle("is-open", open);
    toggle?.setAttribute("aria-expanded", open ? "true" : "false");
    document.body.classList.toggle("nav-open", open);
    document.body.style.overflow = open ? "hidden" : "";
  };
  toggle?.addEventListener("click", () => setOpen(!panel.classList.contains("is-open")));
  closeBtn?.addEventListener("click", () => setOpen(false));
  panel?.querySelectorAll("a").forEach((a) => a.addEventListener("click", () => setOpen(false)));
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") setOpen(false);
  });

  document.querySelectorAll("[data-accordion]").forEach((item) => {
    const btn = item.querySelector("button");
    btn?.addEventListener("click", () => {
      const group = item.parentElement;
      const open = item.classList.contains("is-open");
      group?.querySelectorAll("[data-accordion].is-open").forEach((el) => {
        el.classList.remove("is-open");
        el.querySelector("button")?.setAttribute("aria-expanded", "false");
      });
      item.classList.toggle("is-open", !open);
      btn.setAttribute("aria-expanded", (!open).toString());
    });
  });

  const reveals = document.querySelectorAll("[data-reveal]");
  if (reveals.length && "IntersectionObserver" in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.16, rootMargin: "0px 0px -8% 0px" });
    reveals.forEach((el) => io.observe(el));
  } else {
    reveals.forEach((el) => el.classList.add("is-visible"));
  }

  const trackUrl = document.body.getAttribute("data-track-url");
  const trackClick = (canal, source) => {
    if (!trackUrl || (canal !== "whatsapp" && canal !== "instagram")) return;
    const body = JSON.stringify({
      canal,
      source: source || "",
      pagina: window.location.pathname,
    });
    try {
      if (navigator.sendBeacon) {
        navigator.sendBeacon(trackUrl, new Blob([body], { type: "application/json" }));
        return;
      }
    } catch (_) {}
    fetch(trackUrl, {
      method: "POST",
      body,
      headers: { "Content-Type": "application/json", Accept: "application/json" },
      keepalive: true,
    }).catch(() => {});
  };

  document.addEventListener("click", (event) => {
    const link = event.target.closest("[data-track]");
    if (!link) return;
    trackClick(link.getAttribute("data-track") || "", link.getAttribute("data-track-source") || "");
  });

  document.querySelectorAll("form[data-lead-form]").forEach((form) => {
    form.addEventListener("submit", (event) => {
      event.preventDefault();
      if (form.querySelector("[name=website]")?.value.trim()) return;

      let valid = true;
      form.querySelectorAll("[required]").forEach((field) => {
        const ok = field.type === "checkbox"
          ? field.checked
          : field.value.trim() !== "" && (field.type !== "email" || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value));
        field.setAttribute("aria-invalid", ok ? "false" : "true");
        if (!ok) valid = false;
      });
      if (!valid) return;

      const data = new FormData(form);
      const saveLead = async () => {
        const url = form.getAttribute("data-lead-url") || form.getAttribute("action");
        if (!url) return;
        const ctrl = new AbortController();
        const timer = setTimeout(() => ctrl.abort(), 4000);
        try {
          await fetch(url, {
            method: "POST",
            body: data,
            headers: {
              Accept: "application/json",
              "X-Requested-With": "fetch",
            },
            signal: ctrl.signal,
          });
        } catch (_) {
          /* Si no se pudo guardar, igual se abre WhatsApp. */
        } finally {
          clearTimeout(timer);
        }
      };

      const openWhatsapp = () => {
        if (!form.hasAttribute("data-wa-form")) {
          form.submit();
          return;
        }
        const fmtDate = (value) => {
          if (!value) return "";
          const [y, m, d] = value.split("-");
          return d && m && y ? `${d}/${m}/${y}` : value;
        };
        const contacto = String(data.get("contacto") || "").trim();
        const lines = [
          form.getAttribute("data-wa-intro") || "",
          `Nombre: ${data.get("nombre") || ""}`.trim(),
          ...(contacto ? [`Contacto: ${contacto}`] : []),
          `Cantidad de personas: ${data.get("huespedes") || ""}`.trim(),
          `Llegada: ${fmtDate(String(data.get("checkin") || ""))}`,
          `Salida: ${fmtDate(String(data.get("checkout") || ""))}`,
          `${form.getAttribute("data-wa-room-label") || "Habitación"}: ${data.get("casa") || "A definir"}`,
        ].filter(Boolean);
        const extra = String(data.get("mensaje") || "").trim();
        if (extra) lines.push(`Mensaje: ${extra}`);
        const number = form.getAttribute("data-wa-number") || "";
        window.open(`https://wa.me/${number}?text=${encodeURIComponent(lines.join("\n"))}`, "_blank", "noopener");
      };

      saveLead().finally(openWhatsapp);
    });
  });

  document.querySelectorAll("[data-room]").forEach((link) => {
    link.addEventListener("click", () => {
      const value = link.getAttribute("data-room") || "";
      document.querySelectorAll("form[data-lead-form] select[name=casa]").forEach((select) => {
        if ([...select.options].some((opt) => opt.value === value)) select.value = value;
      });
    });
  });

  const checkin = document.querySelectorAll("input[name=checkin]");
  if (checkin.length) {
    const today = new Date();
    const iso = new Date(today.getTime() - today.getTimezoneOffset() * 60000).toISOString().slice(0, 10);
    document.querySelectorAll("input[name=checkin], input[name=checkout]").forEach((input) => input.setAttribute("min", iso));
    checkin.forEach((input) => {
      input.addEventListener("change", () => {
        const out = input.form?.querySelector("input[name=checkout]");
        if (!out || !input.value) return;
        out.setAttribute("min", input.value);
        if (out.value && out.value < input.value) out.value = "";
      });
    });
  }

  const groups = document.querySelectorAll("[data-lightbox-group]");
  if (groups.length) {
    const box = document.createElement("div");
    box.className = "lightbox";
    box.setAttribute("role", "dialog");
    box.setAttribute("aria-modal", "true");
    box.setAttribute("aria-label", "Galería de fotos");
    box.hidden = true;
    box.innerHTML = `
      <button type="button" class="lightbox-btn lightbox-close" aria-label="Cerrar"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg></button>
      <button type="button" class="lightbox-btn lightbox-prev" aria-label="Foto anterior"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg></button>
      <figure class="lightbox-figure"><img alt=""><figcaption></figcaption></figure>
      <button type="button" class="lightbox-btn lightbox-next" aria-label="Foto siguiente"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg></button>`;
    document.body.appendChild(box);
    const img = box.querySelector("img");
    const caption = box.querySelector("figcaption");
    let items = [];
    let index = 0;
    let lastFocus = null;

    const show = (i) => {
      index = (i + items.length) % items.length;
      const link = items[index];
      const alt = link.querySelector("img")?.getAttribute("alt") || "";
      img.src = link.getAttribute("href");
      img.alt = alt;
      caption.textContent = alt;
    };
    const close = () => {
      box.hidden = true;
      document.body.style.overflow = "";
      lastFocus?.focus();
    };

    groups.forEach((group) => {
      const links = [...group.querySelectorAll("[data-lightbox]")];
      links.forEach((link, i) => {
        link.addEventListener("click", (event) => {
          event.preventDefault();
          items = links;
          lastFocus = link;
          show(i);
          box.hidden = false;
          document.body.style.overflow = "hidden";
          box.querySelector(".lightbox-close").focus();
        });
      });
    });

    box.querySelector(".lightbox-close").addEventListener("click", close);
    box.querySelector(".lightbox-prev").addEventListener("click", () => show(index - 1));
    box.querySelector(".lightbox-next").addEventListener("click", () => show(index + 1));
    box.addEventListener("click", (event) => {
      if (event.target === box) close();
    });
    document.addEventListener("keydown", (event) => {
      if (box.hidden) return;
      if (event.key === "Escape") close();
      if (event.key === "ArrowLeft") show(index - 1);
      if (event.key === "ArrowRight") show(index + 1);
    });
  }

  const params = new URLSearchParams(window.location.search);
  if (params.get("enviado") === "1") {
    document.querySelector("[data-form-success]")?.scrollIntoView({ behavior: "smooth", block: "center" });
  }
})();
