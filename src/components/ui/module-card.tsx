import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { cn } from "@/lib/utils";

interface ModuleCardProps {
  title: string;
  description?: string;
  icon?: React.ReactNode;
  className?: string;
  children?: React.ReactNode;
}

export function ModuleCard({
  title,
  description,
  icon,
  className,
  children
}: ModuleCardProps) {
  return (
    <Card className={cn(
      "overflow-hidden transition-all hover:shadow-lg",
      "border-border/10 bg-card/95 backdrop-blur",
      className
    )}>
      <CardHeader className="space-y-1">
        <div className="flex items-center space-x-2">
          {icon && <div className="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary">
            {icon}
          </div>}
          <CardTitle className="text-xl">{title}</CardTitle>
        </div>
        {description && <p className="text-sm text-muted-foreground">{description}</p>}
      </CardHeader>
      {children && <CardContent>{children}</CardContent>}
    </Card>
  );
} 