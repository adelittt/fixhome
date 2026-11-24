import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import { MotionDemo } from "@/components/demo/MotionDemo";
import { AnimeDemo } from "@/components/demo/AnimeDemo";
import { ChartDemo } from "@/components/demo/ChartDemo";

function DemoPage() {
  return (
    <div className="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
      <header className="mb-8 flex flex-wrap items-center justify-between gap-4 border-b border-border pb-6">
        <div>
          <h1 className="text-2xl font-extrabold tracking-tight text-foreground">
            FixHome — Demo Integrasi UI Libraries
          </h1>
          <p className="mt-1 text-sm text-muted-foreground">
            Motion (<code className="text-xs">motion/react</code>), Anime.js v4,
            dan shadcn/ui Charts (Recharts) berjalan sebagai React Island di
            Laravel + Vite.
          </p>
        </div>
        <a
          href="/"
          className="rounded-full border border-border bg-card px-4 py-2 text-xs font-semibold text-foreground shadow-sm transition-colors hover:bg-muted"
        >
          &larr; Kembali ke Landing Page
        </a>
      </header>

      <main className="space-y-8">
        <MotionDemo />
        <AnimeDemo />
        <ChartDemo />
      </main>
    </div>
  );
}

const mountEl = document.getElementById("demo-root");
if (mountEl) {
  createRoot(mountEl).render(
    <StrictMode>
      <DemoPage />
    </StrictMode>
  );
}
