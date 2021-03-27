import axios from "axios";

const api = axios.create({
    baseURL: "http://localhost:8000"
});

export const getTasks = async () => {
    let { data } = await api.get("/tasks/show");
    return data;
};

export const storeTask = async task => {
    let { data } = await api.post("/tasks/create", {
        name: task.name,
        dimension_id: task.dimension_id
    });
    return data;
};

export const updateTask = async task => {
    let { data } = await api.put(`/task/update/${task.id}`, {
        name: task.name,
        dimension_id: task.dimension_id,
        active: task.active
    });
    return data;
};

export const destroyTask = async id => {
    let { data } = await api.delete(`/task/destroy/${id}`);
    return data;
};

export const getDimensions = async () => {
    let { data } = await api.get("/dimensions/show");
    return data;
};

export const storeDimension = async dimension => {
    let { data } = await api.post("/dimensions/create", { dimension });
    return data;
};

export const updateDimension = async dimension => {
    let { data } = await api.put(`/dimension/update/${dimension.id}`, {
        name: dimension.name
    });
    return data;
};

export const destroyDimension = async id => {
    let { data } = await api.delete(`/dimension/destroy/${id}`);
    return data;
};
