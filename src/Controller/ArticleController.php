<?php
    namespace App\Controller;

    use App\Entity\Article;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Form\Extetsion\Core\Type\TextType;
    use Symfony\Component\Form\Extetsion\Core\Type\TextareaType;
    use Smfony\Component\Form\Extetsion\Core\Type\SubmitType;

    class ArticleController extends Controller{ 
        /**
         * @Route("/", name="article_list")
         * @Method({"GET"})
         */
        public function index(){

           // return new Response('<html><body> Hello sir! </body></html>');

           //$articles = ['Hard coded article 1','Hard coded article 2'];
           $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        

           return $this->render('articles/index.html.twig',array('articles' => $articles));
        }

        /**
         * @Route("/artivle/{id}", name="article_show")
         */
        public function show($id){
            $article = $this->getDoctrine()->getRepository(Article::class)->find(id);

            return $this->render('render/show.html.twig', array('article' => $article));
        }

        /**
         * @Route("/article/new", name="new_article")
         * Method({"GET", "POST"})
         */
        public function new(Request $request){
            $article = new Article();

            $form = $this->createFormBuilder($article)
                ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
                ->add('body', TextareaType::class, array(   'required' => false, 
                                                            'attr'=> array('class' => 'form-control')))
                ->add(  'save', SubmitType::class, 
                        array(  'label' => 'Create',
                                'attr' => array('class' => 'btn btn-primary mt-3')))
                
                ->getForm();

            return $this->render('articles/new.html.twig', array('form'=>$form->createVIew()));
        }

    }