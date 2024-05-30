<aside>
    <nav>
        <ul>
            <li>
                <a href="/admin/buses">
                    <i class="fas fa-bus"></i> Buses
                </a>
                <ul class="submenu">
                    <li>
                        <a href="/admin/buses/create">
                            <i class="fas fa-plus"></i> Create
                        </a>
                    </li>
                    <li>
                        <a href="/admin/buses">
                            <i class="fas fa-list"></i> List
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/admin/drivers">
                    <i class="fas fa-user"></i> Drivers
                </a>
                <ul class="submenu">
                    <li>
                        <a href="/admin/drivers/create">
                            <i class="fas fa-plus"></i> Create
                        </a>
                    </li>
                    <li>
                        <a href="/admin/drivers">
                            <i class="fas fa-list"></i> List
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/admin/governorates">
                    <i class="fas fa-map-marker-alt"></i> Governorates
                </a>
                <ul class="submenu">
                    <li>
                        <a href="/admin/governorates/create">
                            <i class="fas fa-plus"></i> Create
                        </a>
                    </li>
                    <li>
                        <a href="/admin/governorates">
                            <i class="fas fa-list"></i> List
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/admin/trips">
                    <i class="fas fa-route"></i> Trips
                </a>
                <ul class="submenu">
                    <li>
                        <a href="/admin/trips/create">
                            <i class="fas fa-plus"></i> Create
                        </a>
                    </li>
                    <li>
                        <a href="/admin/trips">
                            <i class="fas fa-list"></i> List
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/admin/reservations">
                    <i class="fas fa-ticket-alt"></i> Reservations
                </a>
                <ul class="submenu">
                    <li>
                        <a href="/admin/reservations/create">
                            <i class="fas fa-plus"></i> Create
                        </a>
                    </li>
                    <li>
                        <a href="/admin/reservations">
                            <i class="fas fa-list"></i> List
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>

<style>
    aside {
        background-color: #f4f4f4;
        padding: 1em;
        width: 200px;
        height: 100vh;
        position: fixed;
        overflow-y: auto;
    }

    nav ul {
        list-style: none;
        padding: 0;
    }

    nav li {
        margin: 1em 0;
    }

    nav a {
        text-decoration: none;
        color: #333;
        display: flex;
        align-items: center;
    }

    nav a:hover {
        color: #007bff;
    }

    nav i {
        margin-right: 0.5em;
    }

    .submenu {
        margin-left: 1em;
        display: none;
    }

    nav li:hover .submenu {
        display: block;
    }
</style>
