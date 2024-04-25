export const useForms = () => {

    const rules = {
        required: [(val: any) => !!val || 'لا تترك هذا الحقل فارغا من فضلك'],
        selected: [(val: any) => (val != null) || 'اختر بيانات لهذا الحقل من فضلك'],
    }
    return {rules }
}
