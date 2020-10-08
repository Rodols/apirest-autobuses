CREATE DATABASE IF NOT EXISTS api_rest_autobuses;
USE api_rest_autobuses;

CREATE TABLE users(
    id              int(255) auto_increment not null,
    name            varchar(50),
    surname         varchar(100),
    email           varchar(200),
    password        varchar(200),
    role            varchar(20),
    created_at      datetime DEFAULT NULL,
    updated_at      datetime DEFAULT NULL,
    remember_token  varchar(255),
    CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;


CREATE TABLE buses(
    id              int(255) auto_increment not null,
    number          int(255),
    model           varchar(50),
    available_seats varchar(50),
    fuel_capacity   int(255),
    acquisition     varchar(50),
    created_at      datetime DEFAULT NULL,
    updated_at      datetime DEFAULT NULL,
    CONSTRAINT pk_buses PRIMARY KEY(id)
)ENGINE=InnoDb;


CREATE TABLE bus_routes(
    id              int(255) auto_increment not null,
    name            varchar(200),
    duration        varchar(200),
    start           int(255),
    end             int(255),
    created_at      datetime DEFAULT NULL,
    updated_at      datetime DEFAULT NULL,
    CONSTRAINT pk_bus_routes PRIMARY KEY(id)
)ENGINE=InnoDb;


CREATE TABLE bus_stops(
    id              int(255) auto_increment not null,
    name            varchar(255),
    direction       varchar(255),
    created_at      datetime DEFAULT NULL,
    updated_at      datetime DEFAULT NULL,
    CONSTRAINT pk_bus_stops PRIMARY KEY (id)
)ENGINE=InnoDb;


CREATE TABLE bus_assignments(
    id              int(255) auto_increment not null,
    user_id         int(255) not null,
    bus_route_id    int(255) not null,
    bus_id          int(255) not null,
    created_at      datetime DEFAULT NULL,
    updated_at      datetime DEFAULT NULL,
    CONSTRAINT pk_bus_assignments PRIMARY KEY (id),
    CONSTRAINT fk_bus_assignment_user FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_bus_assignment_route FOREIGN KEY(bus_route_id) REFERENCES bus_routes(id),
    CONSTRAINT fk_bus_assignments_bus FOREIGN KEY(bus_id) REFERENCES buses(id)
)ENGINE=InnoDb;


CREATE TABLE bus_travels(
    id              int(255) auto_increment not null,
    time            int(255),
    start           int(255),
    end             int(255),
    bus_id          int(255),
    bus_route_id    int(255),
    bus_stop_id     int(255),
    updated_at      datetime DEFAULT NULL,
    created_at      datetime DEFAULT NULL,
    CONSTRAINT pk_bus_travels PRIMARY KEY (id),
    CONSTRAINT fk_bus_travel_bus FOREIGN KEY(bus_id) REFERENCES buses(id),
    CONSTRAINT fk_bus_travel_route FOREIGN KEY(bus_route_id) REFERENCES bus_routes(id),
    CONSTRAINT fk_bus_travel_bus_stop FOREIGN KEY(bus_stop_id) REFERENCES bus_stops(id)
)ENGINE=InnoDb;
