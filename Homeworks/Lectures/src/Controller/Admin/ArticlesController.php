<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/admin/articles/create/", name="app_admin_articles_create")
     */
    public function create(EntityManagerInterface $entityManager)
    {
        $article = new Article();
        $article
            ->setTitle('Когда в машинах поставят лоток?')
            ->setSlug('when-they-put-the-toilet-in-the-car-'. rand(10, 999))
            ->setBody(<<<EOF
Lorem ipsum **красная точка** dolor sit amet, consectetur adipiscing elit, sed
do eiusmod tempor incididunt [Сметанка](/) ut labore et dolore magna aliqua.
Purus viverra accumsan in nisl. Diam vulputate ut pharetra sit amet aliquam. Faucibus a
pellentesque sit amet porttitor eget dolor morbi non. Est ultricies integer quis auctor
elit sed. Tristique nulla aliquet enim tortor at. Tristique et egestas quis ipsum. Consequat semper viverra nam
libero. Lectus quam id leo in vitae turpis. In eu mi bibendum neque egestas congue
quisque egestas diam. **Красная точка** blandit turpis cursus in hac habitasse platea dictumst quisque.

*Ullamcorper* malesuada proin libero nunc consequat interdum varius sit amet. Odio pellentesque
diam volutpat commodo sed egestas. Eget nunc lobortis mattis aliquam. Cursus vitae congue
mauris rhoncus aenean vel. Pretium viverra suspendisse potenti nullam ac tortor vitae.
A pellentesque sit amet porttitor eget dolor. Nisl nunc mi ipsum faucibus vitae. Purus sit amet
luctus venenatis lectus magna fringilla urna. Sit amet tellus cras adipiscing enim. Euismod
nisi porta lorem mollis aliquam ut porttitor leo.

Morbi blandit cursus risus at ultrices. Adipiscing vitae proin sagittis nisl rhoncus mattis
rhoncus. Sit amet commodo nulla facilisi. In fermentum et sollicitudin ac orci phasellus
egestas tellus. Sit amet risus nullam eget felis. Dapibus ultrices in iaculis nunc sed
augue lacus viverra. Dictum non consectetur a erat nam at. Odio ut enim blandit volutpat
maecenas. Turpis cursus in hac habitasse platea. Etiam erat velit scelerisque in. Auctor
neque vitae tempus quam pellentesque nec nam aliquam. Odio pellentesque diam volutpat commodo
sed egestas egestas. Egestas dui id ornare arcu odio ut.
EOF
            );

        if(rand(1, 10) > 4) {
            $article->setPublishedAt(new \DateTime(sprintf('-%d days', rand(2, 50))));
        }

        $entityManager->persist($article);
        $entityManager->flush();

        return new Response(sprintf(
            'Создана статья id: %d, slug: %s',
            $article->getId(),
            $article->getSlug()
        ));
    }
}
