<script setup lang="ts">
import {
    Card,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card"

interface Props {
    balanceFormatted: string;
}

const props = defineProps<Props>();
</script>

<template>
    <Card class="@container/card">
        <CardHeader>
            <CardDescription>Acc. Balance (in USD)</CardDescription>
            <CardTitle class="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">
                $ {{ balanceFormatted }}
            </CardTitle>
        </CardHeader>
    </Card>
</template>
