<footer class="footer">
    <p>&copy; <?php echo date('Y'); ?> Asset Management System</p>
    <p>
    </p>
</footer>

<script>

let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-slide');

function changeSlide(direction) {
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + direction + slides.length) % slides.length;
    slides[currentSlide].classList.add('active');
}

setInterval(() => changeSlide(1), 5000);
</script>

<style>
.footer {
    text-align: center;
    padding: 2rem;
    background-color: #2c3e50;
    color: white;
    margin-top: 2rem;
}

.footer a {
    color: white;
    text-decoration: none;
    margin: 0 0.5rem;
}

.footer a:hover {
    text-decoration: underline;
}
</style>

</body>
</html>