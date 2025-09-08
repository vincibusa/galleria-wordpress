<?php
/**
 * Template for displaying artist archive
 */

get_header(); ?>

<main id="main_content" class="main-content">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="mb-12">
            <h1 class="text-4xl font-light mb-8"><?php _e('Artisti', 'galleria'); ?></h1>
            
            <!-- Search Controls -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="relative w-full sm:w-96">
                    <svg class="absolute left-3 top-1 transform -translate-y-1 text-gray-400 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input 
                        type="text" 
                        id="artist-search"
                        placeholder="Cerca artisti..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>
            </div>
            
            <div class="mt-6">
                <p id="artist-count" class="text-sm text-gray-600">
                    <!-- Count will be populated by JavaScript -->
                </p>
            </div>
        </div>

        <!-- Artists List -->
        <main id="artists-container">
            <?php 
            // Override the main query to get ALL artists alphabetically
            global $wp_query;
            $wp_query = new WP_Query(array(
                'post_type' => 'artist',
                'posts_per_page' => -1, // Get all artists, no pagination
                'orderby' => 'title',
                'order' => 'ASC',
                'post_status' => 'publish'
            ));
            
            if (have_posts()) : 
                // Group artists by first letter
                $artists_by_letter = array();
                while (have_posts()) : the_post();
                    $first_letter = strtoupper(substr(get_the_title(), 0, 1));
                    if (!isset($artists_by_letter[$first_letter])) {
                        $artists_by_letter[$first_letter] = array();
                    }
                    $artists_by_letter[$first_letter][] = array(
                        'id' => get_the_ID(),
                        'title' => get_the_title(),
                        'permalink' => get_the_permalink()
                    );
                endwhile;
                
                // Sort by letter
                ksort($artists_by_letter);
                
                // Count total artists
                $total_artists = 0;
                foreach ($artists_by_letter as $artists) {
                    $total_artists += count($artists);
                }
            ?>
                <div class="space-y-12" id="artists-list" data-total="<?php echo esc_attr($total_artists); ?>">
                    <?php foreach ($artists_by_letter as $letter => $artists) : ?>
                        <div class="letter-group space-y-4" data-letter="<?php echo esc_attr($letter); ?>">
                            <h2 class="text-lg font-light text-gray-800 border-b border-gray-200 pb-2">
                                <?php echo esc_html($letter); ?>
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-2">
                                <?php foreach ($artists as $artist) : ?>
                                    <div class="artist-item text-sm font-light py-1 block" data-name="<?php echo esc_attr(strtolower($artist['title'])); ?>">
                                        <?php echo esc_html($artist['title']); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- No results message -->
                <div id="no-results" class="text-center py-16" style="display: none;">
                    <p class="text-gray-500 text-lg font-light">
                        Nessun artista trovato per la ricerca.
                    </p>
                    <button id="clear-search" class="mt-4 px-4 py-2 border border-gray-300 rounded-md text-sm hover:bg-gray-50">
                        Cancella ricerca
                    </button>
                </div>

            <?php
            // Pagination
            the_posts_pagination(array(
                'prev_text' => __('Precedente', 'galleria'),
                'next_text' => __('Successivo', 'galleria'),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Pagina', 'galleria') . ' </span>',
            ));
            ?>

            <?php else : ?>
                <div class="text-center py-16">
                    <p class="text-gray-500 text-lg font-light">
                        <?php _e('Non ci sono artisti da visualizzare al momento.', 'galleria'); ?>
                    </p>
                </div>
            <?php endif; ?>
        </main>
    </div>
</main>

<style>
/* Tailwind-like utilities for artists list */
.max-w-7xl {
    max-width: 80rem;
}

.mx-auto {
    margin-left: auto;
    margin-right: auto;
}

.px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
}

.py-16 {
    padding-top: 4rem;
    padding-bottom: 4rem;
}

.mb-12 {
    margin-bottom: 3rem;
}

.text-4xl {
    font-size: 2.25rem;
    line-height: 2.5rem;
}

.text-lg {
    font-size: 1.125rem;
    line-height: 1.75rem;
}

.text-sm {
    font-size: 0.875rem;
    line-height: 1.25rem;
}

.font-light {
    font-weight: 300;
}

.mb-8 {
    margin-bottom: 2rem;
}

.mt-6 {
    margin-top: 1.5rem;
}

.mt-4 {
    margin-top: 1rem;
}

.text-gray-400 {
    color: #9ca3af;
}

.text-gray-500 {
    color: #6b7280;
}

.text-gray-600 {
    color: #4b5563;
}

.text-gray-800 {
    color: #1f2937;
}

.border-b {
    border-bottom-width: 1px;
}

.border-gray-200 {
    border-color: #e5e7eb;
}

.border-gray-300 {
    border-color: #d1d5db;
}

.pb-2 {
    padding-bottom: 0.5rem;
}

.py-1 {
    padding-top: 0.25rem;
    padding-bottom: 0.25rem;
}

.py-2 {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}

.px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
}

.pl-10 {
    padding-left: 2.5rem;
}

.pr-4 {
    padding-right: 1rem;
}

.space-y-12 > * + * {
    margin-top: 3rem;
}

.space-y-4 > * + * {
    margin-top: 1rem;
}

.gap-x-8 {
    column-gap: 2rem;
}

.gap-y-2 {
    row-gap: 0.5rem;
}

.gap-4 {
    gap: 1rem;
}

.grid {
    display: grid;
}

.grid-cols-1 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
}

.flex {
    display: flex;
}

.flex-col {
    flex-direction: column;
}

.items-start {
    align-items: flex-start;
}

.justify-between {
    justify-content: space-between;
}

.relative {
    position: relative;
}

.absolute {
    position: absolute;
}

.left-3 {
    left: 0.75rem;
}

.top-1 {
    top: 50%;
}

.transform {
    transform: translateY(-50%);
}

.-translate-y-1 {
    transform: translateY(-50%);
}

.w-full {
    width: 100%;
}

.h-4 {
    height: 1rem;
}

.w-4 {
    width: 1rem;
}

.rounded-md {
    border-radius: 0.375rem;
}

.border {
    border-width: 1px;
}

.block {
    display: block;
}

.text-center {
    text-align: center;
}


.hover\:bg-gray-50:hover {
    background-color: #f9fafb;
}

.focus\:ring-2:focus {
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

.focus\:ring-blue-500:focus {
    --tw-ring-color: #3b82f6;
}

.focus\:border-blue-500:focus {
    border-color: #3b82f6;
}

/* Responsive utilities */
@media (min-width: 640px) {
    .sm\:px-6 {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    
    .sm\:flex-row {
        flex-direction: row;
    }
    
    .sm\:items-center {
        align-items: center;
    }
    
    .sm\:w-96 {
        width: 24rem;
    }
}

@media (min-width: 768px) {
    .md\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (min-width: 1024px) {
    .lg\:px-8 {
        padding-left: 2rem;
        padding-right: 2rem;
    }
    
    .lg\:grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('artist-search');
    const artistsContainer = document.getElementById('artists-list');
    const noResultsDiv = document.getElementById('no-results');
    const countElement = document.getElementById('artist-count');
    const clearButton = document.getElementById('clear-search');
    
    // Get all artist items and letter groups
    const artistItems = document.querySelectorAll('.artist-item');
    const letterGroups = document.querySelectorAll('.letter-group');
    const totalArtists = parseInt(artistsContainer.getAttribute('data-total')) || artistItems.length;
    
    // Initialize count
    updateCount(totalArtists);
    
    function updateCount(count) {
        countElement.textContent = count + ' artist' + (count !== 1 ? 'i' : 'a');
    }
    
    function filterArtists(searchTerm) {
        const term = searchTerm.toLowerCase().trim();
        let visibleCount = 0;
        let hasVisibleGroups = false;
        
        letterGroups.forEach(group => {
            const items = group.querySelectorAll('.artist-item');
            let hasVisibleItems = false;
            
            items.forEach(item => {
                const name = item.getAttribute('data-name');
                const isVisible = !term || name.includes(term);
                
                item.style.display = isVisible ? 'block' : 'none';
                
                if (isVisible) {
                    hasVisibleItems = true;
                    visibleCount++;
                }
            });
            
            // Show/hide the entire letter group
            group.style.display = hasVisibleItems ? 'block' : 'none';
            if (hasVisibleItems) {
                hasVisibleGroups = true;
            }
        });
        
        // Show/hide containers based on results
        if (hasVisibleGroups) {
            artistsContainer.style.display = 'block';
            noResultsDiv.style.display = 'none';
        } else {
            artistsContainer.style.display = 'none';
            noResultsDiv.style.display = 'block';
        }
        
        updateCount(visibleCount);
    }
    
    // Search input handler
    searchInput.addEventListener('input', function() {
        filterArtists(this.value);
    });
    
    // Clear search button handler
    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        filterArtists('');
        searchInput.focus();
    });
});
</script>

<?php get_footer(); ?>