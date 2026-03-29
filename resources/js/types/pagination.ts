import type { BasePost } from './models/post';

export interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface PaginatedPosts {
    data: BasePost[];
    current_page: number;
    last_page: number;
    total: number;
    links: PaginationLink[];
}
