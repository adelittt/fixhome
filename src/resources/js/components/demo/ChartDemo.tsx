import { useReducedMotion } from "motion/react";
import {
  Bar,
  BarChart,
  CartesianGrid,
  Line,
  LineChart,
  XAxis,
  YAxis,
} from "recharts";
import {
  ChartContainer,
  ChartLegend,
  ChartLegendContent,
  ChartTooltip,
  ChartTooltipContent,
  type ChartConfig,
} from "@/components/ui/chart";

const MONTHLY_ORDERS_DATA = [
  { month: "Jan", selesai: 186, garansi: 12 },
  { month: "Feb", selesai: 240, garansi: 9 },
  { month: "Mar", selesai: 278, garansi: 11 },
  { month: "Apr", selesai: 312, garansi: 8 },
  { month: "Mei", selesai: 354, garansi: 10 },
  { month: "Jun", selesai: 398, garansi: 7 },
];

const RESPONSE_TREND_DATA = [
  { week: "Mgg 1", rataRataMenit: 28, targetMenit: 30 },
  { week: "Mgg 2", rataRataMenit: 25, targetMenit: 30 },
  { week: "Mgg 3", rataRataMenit: 22, targetMenit: 25 },
  { week: "Mgg 4", rataRataMenit: 24, targetMenit: 25 },
  { week: "Mgg 5", rataRataMenit: 19, targetMenit: 25 },
  { week: "Mgg 6", rataRataMenit: 18, targetMenit: 20 },
];

const barChartConfig = {
  selesai: {
    label: "Perbaikan Selesai",
    color: "hsl(var(--chart-1))",
  },
  garansi: {
    label: "Klaim Garansi",
    color: "hsl(var(--chart-2))",
  },
} satisfies ChartConfig;

const lineChartConfig = {
  rataRataMenit: {
    label: "Respon Aktual (mnt)",
    color: "hsl(var(--chart-1))",
  },
  targetMenit: {
    label: "Target SLA (mnt)",
    color: "hsl(var(--chart-3))",
  },
} satisfies ChartConfig;

export function ChartDemo() {
  const prefersReducedMotion = useReducedMotion();
  const isAnimationActive = !prefersReducedMotion;

  return (
    <section className="rounded-2xl border border-border bg-card p-6 shadow-sm">
      <div className="mb-6">
        <span className="inline-block rounded-full bg-secondary px-3 py-1 text-xs font-semibold text-secondary-foreground">
          3. shadcn/ui Charts (Recharts)
        </span>
        <h2 className="mt-2 text-lg font-bold text-card-foreground">
          Visualisasi Data dengan ChartContainer &amp; ChartConfig
        </h2>
        <p className="text-sm text-muted-foreground">
          Bar Chart &amp; Line Chart responsif berbasis Recharts dengan token
          warna CSS variables.
        </p>
      </div>

      <div className="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {/* Bar Chart */}
        <div className="rounded-xl border border-border bg-background p-4">
          <div className="mb-3">
            <h3 className="text-sm font-bold text-foreground">
              Total Perbaikan Bulanan
            </h3>
            <p className="text-xs text-muted-foreground">
              Perbandingan pesanan selesai vs klaim garansi 14 hari (data dummy)
            </p>
          </div>
          <ChartContainer config={barChartConfig} className="h-[260px] w-full">
            <BarChart accessibilityLayer data={MONTHLY_ORDERS_DATA}>
              <CartesianGrid vertical={false} />
              <XAxis
                dataKey="month"
                tickLine={false}
                tickMargin={10}
                axisLine={false}
              />
              <YAxis tickLine={false} axisLine={false} width={32} />
              <ChartTooltip content={<ChartTooltipContent />} />
              <ChartLegend content={<ChartLegendContent />} />
              <Bar
                dataKey="selesai"
                fill="var(--color-selesai)"
                radius={6}
                isAnimationActive={isAnimationActive}
              />
              <Bar
                dataKey="garansi"
                fill="var(--color-garansi)"
                radius={6}
                isAnimationActive={isAnimationActive}
              />
            </BarChart>
          </ChartContainer>
        </div>

        {/* Line Chart */}
        <div className="rounded-xl border border-border bg-background p-4">
          <div className="mb-3">
            <h3 className="text-sm font-bold text-foreground">
              Tren Kecepatan Respon Teknisi
            </h3>
            <p className="text-xs text-muted-foreground">
              Waktu tiba rata-rata dalam menit dibandingkan target SLA (data
              dummy)
            </p>
          </div>
          <ChartContainer config={lineChartConfig} className="h-[260px] w-full">
            <LineChart accessibilityLayer data={RESPONSE_TREND_DATA}>
              <CartesianGrid vertical={false} />
              <XAxis
                dataKey="week"
                tickLine={false}
                tickMargin={10}
                axisLine={false}
              />
              <YAxis tickLine={false} axisLine={false} width={32} />
              <ChartTooltip content={<ChartTooltipContent />} />
              <ChartLegend content={<ChartLegendContent />} />
              <Line
                type="monotone"
                dataKey="rataRataMenit"
                stroke="var(--color-rataRataMenit)"
                strokeWidth={2.5}
                dot={{ r: 4 }}
                activeDot={{ r: 6 }}
                isAnimationActive={isAnimationActive}
              />
              <Line
                type="monotone"
                dataKey="targetMenit"
                stroke="var(--color-targetMenit)"
                strokeWidth={2}
                strokeDasharray="5 5"
                dot={false}
                isAnimationActive={isAnimationActive}
              />
            </LineChart>
          </ChartContainer>
        </div>
      </div>
    </section>
  );
}
