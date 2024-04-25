export interface LoginType {
    email: string | null;
    password: string | null;
    remember: boolean | false,
}

export interface Accounts {
    id: number | null;
    name: string | null;
    details: string | null;
    user: string | null;
    phone: string | null;
    role: string | null;
    created_at: Date | null;
}

export interface User {
    id: number | null;
    name: string | null;
    email: string | null;
    phone: string | null;
    role: string | null;
    created_at: Date | null;
}


export interface Role {
    title: string | null;
    permissions: [];
    users: [];
}

export interface OptionsValue {
    value: number,
    label: string,
}

export interface Permission {
    title: string,
    details: string,
}

export interface Setting {
    exp_roof: boolean,
    exp_conf: boolean,
}
export interface TeacherData {
    id: number | null;
    name: string;
    address: string | null;
    email: string | null | any;
    phone: string;
    password: string;
    password_confirmation: string;
    details: string;
}
