export const Users = [
    { name: "name", required: true, label: "g.user_name", align: "left", field: "name", format: (val: any) => `${val}`, sortable: true, },
    { name: "email", align: "left", label: "g.email", field: "email", sortable: true, },
    { name: "phone", label: "g.phone_number", field: "phone", sortable: true, align: "left", },
    { name: "role", label: "input.all.role", field: "role", align: "left", },
    { name: "account", label: "input.account.name", field: "account", align: "left" },
    { name: "status", label: "input.user.job", field: "status", align: "left" },
    { name: "created_at", label: "g.created_at", field: "created_at", align: "left" },
    { name: "options", label: "g.options", field: "options" }
]

export const Accounts = [
    { name: "name", required: true, label: "input.account.name", align: "left", field: "name", format: (val: any) => `${val}`, sortable: true, },
    { name: "phone", label: "g.phone_number", field: "phone", sortable: true, align: "left", },
    { name: "role", label: "input.account.role_count", field: "role", sortable: true, align: "left", },
    { name: "user", label: "input.account.user_count", field: "user", align: "left" },
    { name: "details", align: "left", label: "g.details", field: "details", format: (val: any) => `${val.length > 30 ? val.split("", 30).join("") + "..." : val}` },
    { name: "created_at", label: "g.created_at", field: "created_at", align: "left" },
    { name: "options", label: "g.options", field: "options" }
]

export const Roles = [
    { name: "name", required: true, label: "input.role.name", align: "left", field: "title", format: (val: any) => `${val}`, sortable: true },
    { name: "permissions", align: "left", label: "input.account.role_count", field: "permissions", format: (val: any) => `${val.length}`, },
    { name: "users", label: "input.account.user_count", field: "users", align: "left", format: (val: any) => `${val.length}`, },
    { name: "created_at", label: "g.created_at", field: "created_at", align: "left", sortable: true },
    { name: "options", label: "g.options", field: "options" }
]

export const Permissions = [
    { name: "details", required: true, label: "اسم أذن", align: "left", field: "details", sortable: true },
    { name: "title", align: "left", label: " رابط الصلاحية", field: "title" },
    { name: "created_at", label: "g.created_at", field: "created_at", align: "left" },
    { name: "options", label: "الإعدادات", field: "options" }
]
export const TeachersColumns = [
    { name: "name", required: true, label: "input.teacher.name", align: "left", field: "name", sortable: true },
    { name: "phone", label: "g.phone_number", field: "phone", align: "left" },
    { name: "email", label: "g.email", field: "email", align: "left" },
    { name: "address", align: "left", label: "g.address", field: "address" },
    { name: "created_at", label: "g.created_at", field: "created_at", align: "left" },
    { name: "options", label: "g.options", field: "options" }

]
export const MaterialsColumns = [
    { name: "name", required: true, label: "input.material.name", align: "left", field: "name", sortable: true },
    { name: "teacher", required: true, label: "input.teacher.name", align: "left", field: "teacher"},
    { name: "num", required: true, label: "input.material.num", align: "left", field: "num", sortable: true },
    // { name: "email", label: "g.email", field: "email", align: "left" },
    { name: "details", align: "left", label: "g.details", field: "details",format: (val: any) => `${val.length > 50 ? val.split("", 50).join("") + "..." : val}`  },
    { name: "created_at", label: "g.created_at", field: "created_at", align: "left" },
    { name: "options", label: "g.options", field: "options" }

]
