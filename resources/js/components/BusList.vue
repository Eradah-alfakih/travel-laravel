<template>
    <div>
        <h1>Bus List</h1>
        <table>
            <thead>
                <tr>
                    <th>Bus Number</th>
                    <th>Registration Number</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="bus in buses" :key="bus.id">
                    <td>{{ bus.bus_number }}</td>
                    <td>{{ bus.registration_number }}</td>
                    <td>{{ bus.make }}</td>
                    <td>{{ bus.model }}</td>
                    <td>{{ bus.year_of_manufacture }}</td>
                    <td>{{ bus.capacity }}</td>
                    <td>{{ bus.status }}</td>
                    <td>
                        <button @click="editBus(bus)">Edit</button>
                        <button @click="deleteBus(bus.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            buses: [],
        };
    },
    created() {
        this.fetchBuses();
    },
    methods: {
        fetchBuses() {
            axios.get('/api/buses')
                .then(response => {
                    this.buses = response.data;
                });
        },
        editBus(bus) {
            // Logic to edit a bus
        },
        deleteBus(id) {
            axios.delete(`/api/buses/${id}`)
                .then(() => {
                    this.fetchBuses();
                });
        }
    }
};
</script>
