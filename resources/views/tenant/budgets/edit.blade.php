<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Orçamento') }} #{{ $budget->id }} - {{ $budget->client->name }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="budgetEditor({{ $budget->items }}, {{ $products }})">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('tenant.budgets.update', $budget) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Items Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Itens do Orçamento</h3>
                        
                        <table class="min-w-full divide-y divide-gray-200 mb-4">
                            <thead>
                                <tr>
                                    <th class="text-left">Produto</th>
                                    <th class="text-left">Medidas (mm)</th>
                                    <th class="text-left">Qtd</th>
                                    <th class="text-left">Preço Unit.</th>
                                    <th class="text-right">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(item, index) in items" :key="index">
                                    <tr class="border-b">
                                        <td class="py-2">
                                            <select :name="'items['+index+'][product_id]'" x-model="item.product_id" @change="updateProductDetails(index)" class="block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                                <option value="">Selecione...</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->type }})</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="py-2">
                                            <div x-show="isGlass(item.product_id)" class="flex space-x-2">
                                                <input type="number" :name="'items['+index+'][width]'" x-model="item.width" placeholder="Larg" class="w-20 border-gray-300 rounded-md shadow-sm text-sm" @input="calculateItemTotal(index)">
                                                <span class="self-center">x</span>
                                                <input type="number" :name="'items['+index+'][height]'" x-model="item.height" placeholder="Alt" class="w-20 border-gray-300 rounded-md shadow-sm text-sm" @input="calculateItemTotal(index)">
                                            </div>
                                            <div x-show="!isGlass(item.product_id)" class="text-gray-500 text-sm">N/A</div>
                                        </td>
                                        <td class="py-2">
                                            <input type="number" :name="'items['+index+'][quantity]'" x-model="item.quantity" class="w-20 border-gray-300 rounded-md shadow-sm text-sm" @input="calculateItemTotal(index)">
                                        </td>
                                        <td class="py-2">
                                            <input type="number" :name="'items['+index+'][unit_price]'" x-model="item.unit_price" step="0.01" class="w-24 border-gray-300 rounded-md shadow-sm text-sm" @input="calculateItemTotal(index)">
                                        </td>
                                        <td class="py-2 text-right">
                                            R$ <span x-text="item.total_price.toFixed(2)"></span>
                                        </td>
                                        <td class="py-2 text-right">
                                            <button type="button" @click="removeItem(index)" class="text-red-600 hover:text-red-900">X</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>

                        <button type="button" @click="addItem()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                            + Adicionar Item
                        </button>
                    </div>
                </div>

                <!-- Totals Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="notes" :value="__('Observações')" />
                                <textarea id="notes" name="notes" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="3">{{ old('notes', $budget->notes) }}</textarea>
                                
                                <x-input-label for="payment_terms" :value="__('Condições de Pagamento')" class="mt-4" />
                                <textarea id="payment_terms" name="payment_terms" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="2">{{ old('payment_terms', $budget->payment_terms) }}</textarea>
                            </div>
                            
                            <div class="text-right space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">Subtotal:</span>
                                    <span class="text-lg">R$ <span x-text="subtotal.toFixed(2)"></span></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">Desconto:</span>
                                    <input type="number" name="discount" x-model="discount" @input="calculateTotals()" class="w-32 border-gray-300 rounded-md shadow-sm text-right">
                                </div>
                                <div class="flex justify-between items-center border-t pt-2 mt-2">
                                    <span class="font-bold text-xl">Total:</span>
                                    <span class="font-bold text-xl text-green-600">R$ <span x-text="total.toFixed(2)"></span></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('tenant.budgets.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>
                                {{ __('Salvar Orçamento') }}
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function budgetEditor(initialItems, products) {
            return {
                items: initialItems.map(item => ({
                    ...item,
                    product_id: item.product_id, // Ensure ID is set
                    width: item.width || 0,
                    height: item.height || 0,
                    quantity: parseFloat(item.quantity),
                    unit_price: parseFloat(item.unit_price),
                    total_price: parseFloat(item.total_price)
                })),
                products: products,
                discount: {{ $budget->discount ?? 0 }},
                subtotal: 0,
                total: 0,

                init() {
                    if (this.items.length === 0) {
                        this.addItem();
                    }
                    this.calculateTotals();
                },

                addItem() {
                    this.items.push({
                        product_id: '',
                        width: 0,
                        height: 0,
                        quantity: 1,
                        unit_price: 0,
                        total_price: 0
                    });
                },

                removeItem(index) {
                    this.items.splice(index, 1);
                    this.calculateTotals();
                },

                getProduct(id) {
                    return this.products.find(p => p.id == id);
                },

                isGlass(productId) {
                    const product = this.getProduct(productId);
                    return product && product.type === 'glass';
                },

                updateProductDetails(index) {
                    const item = this.items[index];
                    const product = this.getProduct(item.product_id);
                    
                    if (product) {
                        item.unit_price = parseFloat(product.price);
                        this.calculateItemTotal(index);
                    }
                },

                calculateItemTotal(index) {
                    const item = this.items[index];
                    const product = this.getProduct(item.product_id);

                    if (product) {
                        if (product.type === 'glass') {
                            // m2 calculation: (width * height / 1000000) * price * qty
                            const area = (item.width * item.height) / 1000000;
                            item.total_price = area * item.unit_price * item.quantity;
                        } else {
                            // Unit calculation
                            item.total_price = item.unit_price * item.quantity;
                        }
                    } else {
                        item.total_price = 0;
                    }

                    this.calculateTotals();
                },

                calculateTotals() {
                    this.subtotal = this.items.reduce((sum, item) => sum + item.total_price, 0);
                    this.total = this.subtotal - this.discount;
                }
            }
        }
    </script>
</x-app-layout>
