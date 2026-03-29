import type { Category } from './category';

export interface BasePost {
    id: number;
    title: string;
    is_published: boolean;
    created_at: string;
}

export type AdminPost = BasePost;

export interface PublicPost extends BasePost {
    excerpt?: string;
    reading_time?: number;
    author?: string;
    category: Category | null;
}

export interface FullPost extends BasePost {
    content: string;
    image_path: string | null;
    category: Category;
    updated_at: string;
}

export interface EditPost {
    title: string;
    content: string;
    category_id: number;
    image_path: File | null;
    existing_image?: string | null;
    is_published: boolean;
}
