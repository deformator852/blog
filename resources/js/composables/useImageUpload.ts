import { ref } from 'vue';

export function useImageUpload(initialPath: string | null = null) {
    const imagePreview = ref<string | null>(
        initialPath ? `/storage/${initialPath}` : null,
    );
    const imageFile = ref<File | null>(null);

    function handleImage(e: Event) {
        const file = (e.target as HTMLInputElement).files?.[0];

        if (!file) {
            return;
        }

        imageFile.value = file;
        imagePreview.value = URL.createObjectURL(file);
    }

    function removeImage() {
        imageFile.value = null;
        imagePreview.value = null;
    }

    return { imagePreview, imageFile, handleImage, removeImage };
}
