<?php declare(strict_types=1);

namespace Framework312\Template;

interface Renderer {
    public function render(mixed $data, string $template): string;

    /**
     * Tag = a category of templates (e.g. 'books', 'users')
     * Add a new tag to an array inside the function
     * We define the path to the template (e.g. books/template.php )
     */
    public function register(string $tag);
}

/*
Possible implementation:

 class SimpleRenderer implements Renderer {
    private array $templatePaths = [];

    public function register(string $tag): void {
        // Add a path to the template paths array for organizing templates
        $this->templatePaths[$tag] = "./templates/$tag";
    }

    public function render(mixed $data, string $template): string {
        // Extract data array so variables can be used directly in the template
        if (is_array($data)) {
            extract($data);
        }

        // Capture the output of the template
        ob_start();
        include "./templates/$template.php";
        return ob_get_clean();
    }
} 

Example template book_list.php (body tag only):

<body>
    <h1>Book List</h1>
    <ul>
        <?php foreach ($books as $book): ?>
            <li><?php echo htmlspecialchars($book['title']); ?> by <?php echo htmlspecialchars($book['author']); ?></li>
        <?php endforeach; ?>
    </ul>
</body>

Rendering the template:
$renderer = new SimpleRenderer();

// Sample data to pass to the template
$data = [
    'books' => [
        ['title' => '1984', 'author' => 'George Orwell'],
        ['title' => 'Brave New World', 'author' => 'Aldous Huxley']
    ]
];

// Render the template with the data
$html = $renderer->render($data, 'book_list');

// Output the HTML
echo $html;


**/




