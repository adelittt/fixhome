import { useCallback, useEffect, useRef, useState } from "react";
import { createScope, createTimeline, stagger } from "animejs";

const STAGGER_STEPS = [
  { code: "01", label: "Order Masuk" },
  { code: "02", label: "Teknisi Siap" },
  { code: "03", label: "Menuju Lokasi" },
  { code: "04", label: "Pengerjaan" },
  { code: "05", label: "Garansi Aktif" },
];

export function AnimeDemo() {
  const rootRef = useRef<HTMLDivElement | null>(null);
  const scopeRef = useRef<ReturnType<typeof createScope> | null>(null);
  const [replayTick, setReplayTick] = useState(0);

  const runAnimation = useCallback(() => {
    const root = rootRef.current;
    if (!root) return;

    // Bersihkan animasi sebelumnya sebelum memutar ulang
    scopeRef.current?.revert();

    const prefersReducedMotion = window.matchMedia(
      "(prefers-reduced-motion: reduce)"
    ).matches;

    if (prefersReducedMotion) {
      return;
    }

    const scope = createScope({ root }).add(() => {
      const pathEl = root.querySelector<SVGPathElement>(".anime-route-path");
      const pathLength = pathEl ? pathEl.getTotalLength() : 280;

      if (pathEl) {
        pathEl.style.strokeDasharray = `${pathLength}`;
        pathEl.style.strokeDashoffset = `${pathLength}`;
      }

      const tl = createTimeline({
        defaults: {
          ease: "outCubic",
        },
      });

      tl.add(".anime-route-path", {
        strokeDashoffset: [pathLength, 0],
        duration: 900,
      }).add(
        ".anime-stagger-node",
        {
          opacity: [0, 1],
          translateY: [16, 0],
          scale: [0.92, 1],
          duration: 480,
          delay: stagger(90, { from: "first" }),
        },
        "-=450"
      );
    });

    scopeRef.current = scope;
  }, []);

  useEffect(() => {
    runAnimation();
    return () => {
      scopeRef.current?.revert();
      scopeRef.current = null;
    };
  }, [runAnimation, replayTick]);

  return (
    <section className="rounded-2xl border border-border bg-card p-6 shadow-sm">
      <div className="mb-4 flex flex-wrap items-center justify-between gap-3">
        <div>
          <span className="inline-block rounded-full bg-secondary px-3 py-1 text-xs font-semibold text-secondary-foreground">
            2. Anime.js v4 (animejs)
          </span>
          <h2 className="mt-2 text-lg font-bold text-card-foreground">
            Timeline SVG Path &amp; Stagger Non-React
          </h2>
          <p className="text-sm text-muted-foreground">
            Dibungkus{" "}
            <code className="rounded bg-muted px-1 py-0.5 text-xs">
              useEffect
            </code>
            /
            <code className="rounded bg-muted px-1 py-0.5 text-xs">useRef</code>{" "}
            dengan{" "}
            <code className="rounded bg-muted px-1 py-0.5 text-xs">
              createScope().revert()
            </code>{" "}
            saat unmount serta menghormati{" "}
            <code className="rounded bg-muted px-1 py-0.5 text-xs">
              prefers-reduced-motion
            </code>
            .
          </p>
        </div>

        <button
          type="button"
          onClick={() => setReplayTick((tick) => tick + 1)}
          className="rounded-full border border-border bg-background px-4 py-2 text-xs font-semibold text-foreground shadow-sm transition-colors hover:bg-muted"
        >
          Putar Ulang Timeline
        </button>
      </div>

      <div ref={rootRef} className="space-y-4">
        {/* SVG Path Animation */}
        <div className="rounded-xl border border-border bg-background p-4">
          <svg
            viewBox="0 0 560 72"
            className="h-16 w-full"
            role="img"
            aria-label="Alur progres perbaikan rumah FixHome"
          >
            <path
              d="M 24 44 C 110 8, 180 68, 280 36 C 370 8, 450 64, 536 28"
              fill="none"
              stroke="hsl(var(--border))"
              strokeWidth="4"
              strokeLinecap="round"
            />
            <path
              className="anime-route-path"
              d="M 24 44 C 110 8, 180 68, 280 36 C 370 8, 450 64, 536 28"
              fill="none"
              stroke="hsl(var(--primary))"
              strokeWidth="4"
              strokeLinecap="round"
            />
          </svg>
        </div>

        {/* Staggered Nodes (animated exclusively by Anime.js, not Motion) */}
        <div className="grid grid-cols-2 gap-3 sm:grid-cols-5">
          {STAGGER_STEPS.map((step) => (
            <div
              key={step.code}
              className="anime-stagger-node rounded-xl border border-border bg-background p-3 text-center"
            >
              <span className="block text-xs font-extrabold text-primary">
                {step.code}
              </span>
              <span className="mt-1 block text-xs font-medium text-foreground">
                {step.label}
              </span>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
