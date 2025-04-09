<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('blog/home.html.twig');
    }

    #[Route('/articles', name: 'article_list')]
    public function list(): Response
    {
        $file = $this->getParameter('kernel.project_dir') . '/var/articles.json';
        $articles = [];

        if (file_exists($file)) {
            $content = file_get_contents($file);
            $articles = json_decode($content, true) ?? [];
        }

        return $this->render('blog/list.html.twig', [
            'articles' => $articles,
        ]);
    }


    #[Route('/article/{slug}', name: 'article_show')]
    public function show(string $slug): Response
    {
        $file = $this->getParameter('kernel.project_dir') . '/var/articles.json';
        $articles = [];

        if (file_exists($file)) {
            $content = file_get_contents($file);
            $articles = json_decode($content, true) ?? [];
        }

        // Chercher l'article avec le bon slug
        $article = array_filter($articles, fn($a) => $a['slug'] === $slug);
        $article = reset($article); // retourne le premier (ou false si rien trouvé)

        if (!$article) {
            throw $this->createNotFoundException('Article non trouvé');
        }

        return $this->render('blog/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/new', name: 'article_new')]
    public function new(Request $request): Response
    {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Créer un slug automatiquement
            $slug = strtolower(str_replace(' ', '-', $data['title']));

            // Charger les articles existants
            $file = $this->getParameter('kernel.project_dir') . '/var/articles.json';
            $articles = [];

            if (file_exists($file)) {
                $content = file_get_contents($file);
                $articles = json_decode($content, true) ?? [];
            }

            // Ajouter le nouvel article
            $articles[] = [
                'title' => $data['title'],
                'slug' => $slug,
                'content' => $data['content'],
            ];

            // Sauvegarder
            file_put_contents($file, json_encode($articles, JSON_PRETTY_PRINT));

            return $this->redirectToRoute('article_list');
        }

        return $this->render('blog/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
