document.addEventListener('DOMContentLoaded', () => {
    const disallowedBlocks = [
        'core/comments',
        'core/comment-title',
        'core/comment-template',
        'core/comment-name',
        'core/comment-date',
        'core/comment-content',
        'core/comment-reply-link',
        'core/comment-edit-link',
        'core/comments-pagination',
        'core/comments-pagination-next',
        'core/comments-pagination-previous',
        'core/comments-pagination-numbers',
        'core/post-comments-form',
        'core/post-comments-count',
        'core/post-comments-link',
        'core/latest-comments',
    ];

    disallowedBlocks.forEach((block) => {
        // @ts-expect-error: We need to use the `wp` global object to access the block editor.
        wp.blocks.unregisterBlockType(block);
    });
});
