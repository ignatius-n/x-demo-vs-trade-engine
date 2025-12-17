<script setup lang="ts">
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import { Form, Link } from '@inertiajs/vue3';
import { useTemplateRef } from 'vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

// Components
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { Checkbox } from '@/components/ui/checkbox';
import InputError from '@/components/InputError.vue';
import {
    Field,
    FieldDescription,
    FieldGroup,
    FieldLabel,
    FieldLegend,
    FieldSeparator,
    FieldSet,
} from '@/components/ui/field';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { route } from 'ziggy-js';
import { send } from '@/routes/verification';
import OrderController from '@/actions/App/Http/Controllers/OrderController';

interface Props {
    assetOptions: Array<string>;
    sidesOptions: Array<string>;
}

const props = withDefaults(defineProps<Props>(), {
    assetOptions: () => [],
    sidesOptions: () => [],
});

const passwordInput = useTemplateRef('passwordInput');

const form = ref({
    symbol: 'BTC',
    side: 'buy',
    price: '',
    amount: '',
});

const submit = () => {
    router.post(route('dashboard.orders.store'), form.value);
};
</script>

<template>
    <div class="space-y-6">
        <Dialog>
            <DialogTrigger as-child>
                <Button variant="default" data-test="delete-user-button"
                    >Create Order</Button
                >
            </DialogTrigger>
            <DialogContent>
                <Form
                    v-bind="OrderController.store.form()"
                    class="space-y-6"
                    reset-on-success
                    :options="{
                        preserveScroll: true,
                    }"
                    v-slot="{ errors, processing, recentlySuccessful, reset, clearErrors }"
                >
                    <DialogHeader class="space-y-3">
                        <DialogTitle> Place Limit Order </DialogTitle>
                    </DialogHeader>
                    <DialogDescription>
                        You can place a limit order to buy or sell a specific
                        asset.
                    </DialogDescription>


                    <div class="grid gap-4">
                        <FieldGroup>
                            <FieldSet>
                                <FieldGroup>
                                    <div class="grid grid-cols-2 gap-4 pb-8">
                                        <Field>
                                            <FieldLabel for="symbol">Symbol</FieldLabel>
                                            <Select id="symbol" name="symbol" required>
                                                <SelectTrigger><SelectValue placeholder="Select Symbol" /></SelectTrigger>
                                                <SelectContent>
                                                    <SelectItem v-for="(symbol, value) in props.assetOptions" :key="value" :value="value">
                                                        {{ value }}
                                                    </SelectItem>
                                                </SelectContent>
                                            </Select>
                                            <InputError class="mt-2" :message="errors.symbol" />
                                        </Field>
                                        <Field>
                                            <FieldLabel for="side">Side</FieldLabel>
                                            <Select id="side" name="side" required>
                                                <SelectTrigger><SelectValue placeholder="Select Side" /></SelectTrigger>
                                                <SelectContent>
                                                    <SelectItem v-for="(side, value) in props.sidesOptions" :key="value" :value="value">
                                                        {{ side }}
                                                    </SelectItem>
                                                </SelectContent>
                                            </Select>
                                            <InputError class="mt-2" :message="errors.side" />
                                        </Field>
                                        <Field>
                                            <FieldLabel for="price">Price</FieldLabel>
                                            <Input id="price" name="price" type="number" step="0.01" placeholder="Asset price" required />
                                            <InputError class="mt-2" :message="errors.price" />
                                        </Field>
                                        <Field>
                                            <FieldLabel for="amount">Amount</FieldLabel>
                                            <Input id="amount" name="amount" type="number" step="0.00000001" placeholder="Amount" required />
                                            <InputError class="mt-2" :message="errors.amount" />
                                        </Field>
                                    </div>
                                </FieldGroup>
                            </FieldSet>
                        </FieldGroup>
                    </div>

                    <DialogFooter class="gap-2">
                        <DialogClose as-child>
                            <Button variant="secondary" @click="() => { clearErrors(); reset(); }">
                                Cancel
                            </Button>
                        </DialogClose>

                        <div class="flex items-center gap-4">
                            <Button :disabled="processing" data-test="create-order-button">Create order</Button>
                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p v-show="recentlySuccessful" class="text-sm text-neutral-600">
                                    Created.
                                </p>
                            </Transition>
                        </div>
                    </DialogFooter>
                </Form>
            </DialogContent>
        </Dialog>
    </div>
</template>
