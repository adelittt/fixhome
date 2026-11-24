import { useState } from "react";
import { AnimatePresence, motion, useReducedMotion } from "motion/react";

interface ServiceHighlight {
  id: string;
  label: string;
  title: string;
  description: string;
  price: string;
}

const SERVICE_HIGHLIGHTS: ServiceHighlight[] = [
  {
    id: "pipa",
    label: "Pipa & Sanitasi",
    title: "Perbaikan Pipa Bocor & Saluran",
    description:
      "Penanganan cepat kebocoran pipa, instalasi pompa booster, dan pembersihan saluran mampet bergaransi 14 hari.",
    price: "Mulai Rp75.000",
  },
  {
    id: "listrik",
    label: "Kelistrikan",
    title: "Instalasi & Perbaikan Panel Listrik",
    description:
      "Pengecekan korsleting, pemasangan MCB, titik lampu, serta grounding oleh teknisi bersertifikasi.",
    price: "Mulai Rp85.000",
  },
  {
    id: "ac",
    label: "Perawatan AC",
    title: "Cuci AC & Isi Freon Standar",
    description:
      "Pembersihan unit indoor/outdoor menyeluruh, cek tekanan freon R32/R410A, dan perbaikan kebocoran air.",
    price: "Mulai Rp65.000",
  },
];

export function MotionDemo() {
  const [selectedId, setSelectedId] = useState<string>(SERVICE_HIGHLIGHTS[0].id);
  const [isVisible, setIsVisible] = useState<boolean>(true);
  const prefersReducedMotion = useReducedMotion();

  const activeItem =
    SERVICE_HIGHLIGHTS.find((item) => item.id === selectedId) ??
    SERVICE_HIGHLIGHTS[0];

  const transition = prefersReducedMotion
    ? { duration: 0.01 }
    : { duration: 0.28, ease: [0.22, 1, 0.36, 1] as const };

  return (
    <section className="rounded-2xl border border-border bg-card p-6 shadow-sm">
      <div className="mb-4 flex flex-wrap items-center justify-between gap-3">
        <div>
          <span className="inline-block rounded-full bg-secondary px-3 py-1 text-xs font-semibold text-secondary-foreground">
            1. Motion (motion/react)
          </span>
          <h2 className="mt-2 text-lg font-bold text-card-foreground">
            Fade &amp; Slide-In dengan AnimatePresence
          </h2>
          <p className="text-sm text-muted-foreground">
            Transisi komponen React, gesture tap/hover, dan dukungan otomatis{" "}
            <code className="rounded bg-muted px-1 py-0.5 text-xs">
              prefers-reduced-motion
            </code>
            .
          </p>
        </div>

        <motion.button
          type="button"
          whileHover={prefersReducedMotion ? undefined : { scale: 1.03 }}
          whileTap={prefersReducedMotion ? undefined : { scale: 0.97 }}
          onClick={() => setIsVisible((prev) => !prev)}
          className="rounded-full bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground shadow-sm transition-opacity hover:opacity-95"
        >
          {isVisible ? "Sembunyikan Kartu" : "Tampilkan Kartu"}
        </motion.button>
      </div>

      {/* Category Tabs */}
      <div className="mb-4 flex flex-wrap gap-2" role="tablist">
        {SERVICE_HIGHLIGHTS.map((item) => {
          const isActive = item.id === selectedId;
          return (
            <button
              key={item.id}
              type="button"
              role="tab"
              aria-selected={isActive}
              onClick={() => {
                setSelectedId(item.id);
                setIsVisible(true);
              }}
              className={`relative rounded-full px-4 py-1.5 text-xs font-semibold transition-colors ${
                isActive
                  ? "text-primary-foreground"
                  : "bg-muted text-muted-foreground hover:text-foreground"
              }`}
            >
              {isActive && (
                <motion.span
                  layoutId="motion-demo-active-tab"
                  transition={transition}
                  className="absolute inset-0 rounded-full bg-primary"
                />
              )}
              <span className="relative z-10">{item.label}</span>
            </button>
          );
        })}
      </div>

      {/* Animated Card Container */}
      <div className="min-h-[132px]">
        <AnimatePresence mode="wait">
          {isVisible && (
            <motion.div
              key={activeItem.id}
              initial={{ opacity: 0, y: prefersReducedMotion ? 0 : 14 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: prefersReducedMotion ? 0 : -14 }}
              transition={transition}
              className="rounded-xl border border-border bg-background p-5"
            >
              <div className="flex flex-wrap items-start justify-between gap-2">
                <h3 className="text-base font-bold text-foreground">
                  {activeItem.title}
                </h3>
                <span className="rounded-full bg-secondary px-3 py-0.5 text-xs font-semibold text-secondary-foreground">
                  {activeItem.price}
                </span>
              </div>
              <p className="mt-2 text-sm leading-relaxed text-muted-foreground">
                {activeItem.description}
              </p>
            </motion.div>
          )}
        </AnimatePresence>
      </div>
    </section>
  );
}
